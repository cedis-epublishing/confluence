====================================
=== Confluence Plugin
=== Author: Svantje Lilienthal, Center for Digital Systems 
=== Date 2016-02-09
=== Version: 1.2
====================================

About
-----
The Confluence plugin enables the display of image galleries ([FancyBox](http://fancyapps.com/fancybox/)) and the HTML5 video player ([video.js](http://videojs.com/)) in html files in Open Journal System. 
It is written to allow users to display HTML files, that contain image galleries and html5 video players and have been exported from the confluence wiki in OJS. But it can also be used in other HTML files.

How to use the videoplayer
--------------------------

Insert a html5 video tag to your page. Use the class "video-js" to activate the player. 

<video id="my-video" class="video-js" controls preload="auto" width="640" height="264" poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
    <source src="MY_VIDEO.mp4" type='video/mp4'>
</video>

[More infos](http://docs.videojs.com/docs/guides/setup.html#step-2-add-an-html5-video-tag-to-your-page-)

How to use the imagegallery
---------------------------

Add the images enclosed in links with the image as href:

<a class="fancybox" rel="group" href="big_image_1.jpg"><img src="small_image_1.jpg" alt="" /></a>
<a class="fancybox" rel="group" href="big_image_2.jpg"><img src="small_image_2.jpg" alt="" /></a>

Activate the image gallery below (here you can also add [settings](http://fancyapps.com/fancybox/#useful)):

<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>

[More infos](http://fancyapps.com/fancybox/#instructions)


License
-------
This plugin is licensed under the GNU General Public License v2. See the file
LICENSE for the complete terms of this license.

The [FancyBox](http://fancyapps.com/fancybox/) is included in this plugin under its own
license (currently [Creative Commons Attribution-NonCommercial 3.0](http://creativecommons.org/licenses/by-nc/3.0/) licence).


System Requirements
-------------------
The plugin has no system requirements.


Installation
------------
To install the plugin:
 - as Manager, go into the "System Plugins" page and enable the plugin.
 - as server admin, include this plugin as a submodule in /plugins/generic


Localization
------------
The plugin has no interfaces.

Contact/Support
---------------
Please contact the Center for Digital Systems for support, bugfixes, or comments.
[www.cedis.fu-berlin.de](http://www.cedis.fu-berlin.de/)
[e-publishing@cedis.fu-berlin.de](mailto:e-publishing@cedis.fu-berlin.de)


Documentation
-------------

ConfluencePlugin.inc.php - adds the scripts for image gallery and video player to the header of each article page (article/article.tpl) by using the variable {$additionalHeadData}.
fancybox - includes the scripts (js and css) and icons for the fancybox.
fancybox/fancybox.css - default style for the image gallery, including our icon-slideshow.gif for spans with class="fancy-slideshow-icon".
video-player -  includes the scripts (js and css) for the video player.
locale - includes the translation of the plugin desciption.
style.css - includes specific style for the confluence html files (TODO: remove for community version).

