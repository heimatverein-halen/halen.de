# Halen theme

The look of halen.de: a child theme of [Quark 2](https://github.com/getgrav/grav-theme-quark2), the Grav 2
default theme. Quark 2 is installed and updated by GPM (`bin/gpm install quark2`, not in git). Every file here
replaces the Quark 2 file with the same path, or adds something Quark 2 doesn't have. Everything else comes from
Quark 2.

## Settings

`halen.yaml` holds the Quark 2 options (a child theme does not inherit them): light mode by default, forest green accent,
the `halen.svg` wordmark as logo, Font Awesome served locally, sidebar on blog lists. The admin shows the same
form as Quark 2 (`extends@` in `blueprints.yaml`).

## What is ours

| File | Why |
| --- | --- |
| `templates/default.html.twig`, `partials/entry.html.twig` | Pages and posts with title, date, tags, photos and the sidebar. The first photo comes before the text (with the photo count when there are more), the others in a grid after it. Quark 2's `default` shows only the text. |
| `partials/base.html.twig` | Quark 2's page frame (extended via the `@quark2` namespace, `halen.yaml`) plus a search link (last in the menu row, next to "Menü" on phones) and a few lines that make the theme toggle switch only between light and dark (no "auto"). |
| `templates/calendar.html.twig`, `halen.php` | Dorfkalender: lists the events of the uploaded `.ics` file(s), with links to subscribe and download. |
| `partials/gallery.html.twig`, `partials/lightbox.html.twig` | Photo grid and the PhotoSwipe lightbox with counter and caption (`js/photoswipe*.esm.min.js`, `css/photoswipe.css`, MIT, v5.4.4). |
| `partials/blog-list-item.html.twig` | Quark 2's card plus one line: "Weiterlesen" only when the page has more than the card shows. |
| `partials/archives.html.twig` | Archive list by year (Quark 2's lists months). |
| `partials/blog/date.html.twig` | Date only when the page sets one (Grav otherwise shows the file time). |
| `partials/footer.html.twig` | Links to the legal pages (category `impressum`) instead of the theme credits. |
| `partials/metadata.html.twig` | Grav's page metadata plus a description per page (from the page text) and link previews (Open Graph) with the page's first photo, else the club emblem. Replaces Grav's own file of the same name, not a Quark 2 file. |
| `partials/simplesearch_searchbox.html.twig` | The search plugin's box, with `autofocus` only on the search page (elsewhere it scrolled phones down to the sidebar). Includes the plugin's own file via the `@simplesearch` namespace (`halen.yaml`) instead of copying it. |
| `css/custom.css` | Colors, wordmark, white page cards, blog title placement, clickable cards without inline photos, photo grid, Dorfkalender. |
| `css/fontawesome/`, `css/webfonts/` | Font Awesome 7.0.1 free, so no request goes to a CDN. |
| `images/logo/halen.svg` | "Halen" in Quark 2's Cal Sans, as paths. |
| `languages.yaml` | German texts for Quark 2, which ships English and Spanish only. |

The club box in the sidebar is the content page `pages/modules/sidebar`, which Quark 2's sidebar shows on its
own.

The old theme `pinpress-halen` stays installed for a few weeks as a fallback (switch the theme in the admin).
Delete it once the new theme has proven itself.

## After a Quark 2 update

Look at Quark 2's changelog for changes to the files listed above, and check the home page, a post, the
Dorfkalender and a phone-sized window.
