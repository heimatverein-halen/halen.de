---
title: Aktuelles
content:
    items: '@self.children'
    order:
        by: date
        dir: desc
    limit: 10
    pagination: true
process:
    markdown: false
    twig: true
cache_enable: false
---

{# Next event from the Dorfkalender (calendar_events() in themes/halen/halen.php). Not cached, so it stays current. #}
{% set kalender = page.find('/dorfkalender') %}
{% set termin = kalender ? calendar_events(kalender)|first : null %}
{% if termin %}
<a class="naechster-termin" href="{{ kalender.url }}">
<span class="icon"><i class="fa-solid fa-calendar" aria-hidden="true"></i></span>
<span class="text"><small>{{ termin.day|split(' ')|slice(0, -1)|join(' ')|e }}</small>{{ termin.title|e }}</span>
<span class="mehr"><span>Alle Termine </span>&rarr;</span>
</a>
{% endif %}
