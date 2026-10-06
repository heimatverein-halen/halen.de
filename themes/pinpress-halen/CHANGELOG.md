# v1.5.0
## 10/06/2026

1. [](#new)
    * Fork of pinpress 1.4.1 for halen.de, renamed to pinpress-halen
    * Merged upstream autoescape fixes (1.4.1 + develop) into the Halen templates
1. [](#improved)
    * Grav 2 / Twig 3 ready: |raw on all content and media output
    * Dorfkalender: removed isMobile(), FullCalendar libs only load on the calendar page
    * item.css via asset pipeline instead of repeated <link> tags (list_in_one put it before the doctype)
    * Fonts and Font Awesome over https, removed dead IE/html5shiv code, dead head script and unused bundled libs
1. [](#bugfix)
    * default_mit_bild used an undefined `image` variable for the alt text
    * About widget printed a stray quote after the logo

# v1.4.1
## 01/15/2021

1. [](#improved)
    * Fixed autoescaping in preparation for Grav 1.7

# v1.4.0
## 03/21/2019

1. [](#new)
    * Set Dependency of Grav 1.5.10+ which has support for new **Deferred Block** Twig extension
    * Implement assets rendering using **Deferred Block** Twig extension 

# v1.3.0
## 11/10/2016

1. [](#bugfix)
    * Fix comments form, the custom twig provides no custom styling and breaks it

# v1.2.0
## 07/14/2016

1. [](#new)
    * Enable dropdown for visible menu items subpages
1. [](#improved)
    * Remove unneeded streams from Theme YAML
    * Delete unused composer.json
1. [](#bugfix)
    * Fix pagination
    * Fix setting the page language in the html tag

# v1.1.0
## 01/06/2016

1. [](#bugfix)
    * Responsive fix
    * Fix for continue link
    * Fix for ordered list styling
    * Fix for related pages item links

# v1.0.0
## 12/03/2015

1. [](#new)
    * ChangeLog started...
