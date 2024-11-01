=== Smart Search Stellenanzeigen ===
Tags: Bewerber Management
Contributors: Tjerk
Requires at least: 5.2
Requires PHP: 7.4
Tested up to: 6.1
Stable tag: 1.0.4
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html


The Smart Search Stellenanzeigen plugin connects your Site with the SmartSearch Api.
It will automatically load Jobs into you Site.


Connections:

The plugin will connect to the API on https://api.smartsearch.business. This is needed to fetch jobs into your Site.
It will also fetch data from open street map https://nominatim.openstreetmap.org to allow your users to filter jobs by region.
To print out flags for a jobs location we're using https://flagcdn.com. The Plugin will fetch images from there by a given location like for example "de" or "ch"

Since it's only a data fetching there will no data sent to this API exept the company or region filter you're using.


== Description ==

This Plugin will enable you to manage your Applicants on your page.


== Changelog ==

1.0.1
* Added shortcode generator

1.0.1
* Fixed a bug where the plugin cannot log

1.0.0
* Initiall Deployment