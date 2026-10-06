<?php
namespace Grav\Theme;

use DateTimeImmutable;
use DateTimeZone;
use Grav\Common\Page\Interfaces\PageInterface;
use Twig\TwigFunction;

class Halen extends Quark2
{
    private const TIMEZONE = 'Europe/Berlin';

    public static function getSubscribedEvents(): array
    {
        return parent::getSubscribedEvents() + [
            'onTwigExtensions' => ['onTwigExtensions', 0],
        ];
    }

    public function onTwigExtensions(): void
    {
        $this->grav['twig']->twig()->addFunction(new TwigFunction('calendar_events', [$this, 'calendarEvents']));
    }

    /**
     * Upcoming events from every .ics file in the page folder (the yearly calendar upload).
     *
     * @return array<int, array{start: DateTimeImmutable, end: DateTimeImmutable, all_day: bool, day: string, time: ?string, title: string, location: string}>
     */
    public function calendarEvents(PageInterface $page, int $days = 365): array
    {
        $tz = new DateTimeZone(self::TIMEZONE);
        $from = new DateTimeImmutable('today', $tz);
        $until = $from->modify("+{$days} days");

        $events = [];
        foreach (glob($page->path() . '/*.ics') ?: [] as $file) {
            foreach ($this->parseIcs((string) file_get_contents($file), $tz) as $event) {
                if ($event['end'] > $from && $event['start'] < $until) {
                    $events[] = $event;
                }
            }
        }
        usort($events, static fn ($a, $b) => [$a['start'], $a['title']] <=> [$b['start'], $b['title']]);

        return $events;
    }

    private function parseIcs(string $ics, DateTimeZone $tz): array
    {
        // Unfold continuation lines (RFC 5545 3.1).
        $ics = preg_replace("/\r?\n[ \t]/", '', $ics);

        $events = [];
        $props = null;
        foreach (preg_split("/\r?\n/", $ics) as $line) {
            if ($line === 'BEGIN:VEVENT') {
                $props = [];
            } elseif ($line === 'END:VEVENT') {
                if ($props !== null && isset($props['DTSTART'])) {
                    $events[] = $this->buildEvent($props, $tz);
                }
                $props = null;
            } elseif ($props !== null && str_contains($line, ':')) {
                [$head, $value] = explode(':', $line, 2);
                $params = explode(';', $head);
                $name = strtoupper(array_shift($params));
                $props[$name] = ['value' => $value, 'params' => strtoupper(implode(';', $params))];
            }
        }

        return $events;
    }

    private function buildEvent(array $props, DateTimeZone $tz): array
    {
        [$start, $allDay] = $this->parseDate($props['DTSTART'], $tz);
        if (isset($props['DTEND'])) {
            [$end] = $this->parseDate($props['DTEND'], $tz);
        } else {
            $end = $allDay ? $start->modify('+1 day') : $start;
        }

        $time = null;
        if (!$allDay) {
            $time = $start->format('H:i') . ($end > $start ? ' - ' . $end->format('H:i') : '') . ' Uhr';
        } elseif ($end > $start->modify('+1 day')) {
            // DTEND of all-day events is exclusive.
            $time = 'bis ' . $this->formatDay($end->modify('-1 day'));
        }

        return [
            'start' => $start,
            'end' => $end,
            'all_day' => $allDay,
            'day' => $this->formatDay($start),
            'time' => $time,
            'title' => $this->unescape($props['SUMMARY']['value'] ?? ''),
            'location' => $this->unescape($props['LOCATION']['value'] ?? ''),
        ];
    }

    /** @return array{0: DateTimeImmutable, 1: bool} */
    private function parseDate(array $prop, DateTimeZone $tz): array
    {
        $value = $prop['value'];
        if (str_contains($prop['params'], 'VALUE=DATE') || preg_match('/^\d{8}$/', $value)) {
            return [DateTimeImmutable::createFromFormat('!Ymd', substr($value, 0, 8), $tz), true];
        }

        $zone = $tz;
        if (str_ends_with($value, 'Z')) {
            $zone = new DateTimeZone('UTC');
        } elseif (preg_match('/TZID=([^;]+)/', $prop['params'], $m)) {
            try {
                $zone = new DateTimeZone($m[1]);
            } catch (\Exception) {
            }
        }
        $date = DateTimeImmutable::createFromFormat('Ymd\THis', substr($value, 0, 15), $zone);

        return [$date->setTimezone($tz), false];
    }

    private function formatDay(DateTimeImmutable $date): string
    {
        $language = $this->grav['language'];
        $weekday = $language->translateArray('GRAV.DAYS_OF_THE_WEEK', (int) $date->format('N') - 1);
        $month = $language->translateArray('GRAV.MONTHS_OF_THE_YEAR', (int) $date->format('n') - 1);

        return sprintf('%s, %d. %s %s', $weekday, (int) $date->format('j'), $month, $date->format('Y'));
    }

    private function unescape(string $text): string
    {
        return trim(strtr($text, ['\\n' => "\n", '\\N' => "\n", '\\,' => ',', '\\;' => ';', '\\\\' => '\\']));
    }
}
