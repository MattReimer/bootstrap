BOOTSTRAP THEME FOR DRUPAL 7
----------------------------------------------------------------------
This theme is a basic port of Twitter's "Bootstrap" [1] development
framework to Drupal 7. It probably can be used as a theme out-of-the-
box, but is intended to be used as a parent theme. The theme itself is
currently at an early stage of development, but appears reliable and
stable. Implemented features should simply work with Drupal 7 and with
the Webform module.

However, please note:

  1.  this theme is at an early stage of development and could change
      drastically prior to a major release,
  2.  this theme replaces many of Drupal's default stylesheets and so
      should probably NOT be used as an admin theme--ymmv
  3.  though the theme was built using Less, and though it is expected
      that sub-themes will also be built using Less, using Less with
      Drupal is currently not very reliable, and the theme contains no
      provision for using Less directly (i.e. when developing sub-
      themes, it will be necessary to compile a *.less file into a CSS
      file)



STRATEGY
----------------------------------------------------------------------
Bootstrap's markup and Drupal's are often similar, but can be quite
different. This theme employs two strategies to overcome this differ-
ence:

  1.  Remove Drupal (and module) stylesheets where they do more harm
      than good; in other words, rather than duplicate styles (such as
      Drupal's menu styles) that are amply handled by Bootstrap, simp-
      ly use the theme info file to remove them altogether, and
  2.  whenever possible--that is, wherever Bootstrap and Drupal have
      sufficiently similar markup--"map" Bootstrap styles onto Drupal
      markup using Less [2], or
  3.  use theming functions or template files to modify Drupal's html
      (as minimally as is practical) so that Bootstrap's CSS will work
      directly; in these cases, I have tried to keep the theming
      functions as close as possible to the original functions con-
      tained in core or in the modules that provide the originals.
      
For example, it was more practical, in the case of Drupal's status
messages to re-theme the messages than it was to map Bootstrap CSS to
them. Consequently, the file at lib/less/system.messages.less contains
almost nothing, but there is an implementation of 
template_status_messages() in template.php. On the other hand, when
theming Bootstrap's 'Hero unit', it was more convenient to provide
a special, region-specific block template (see '"Hero" unit,' below,
for more details).

Building subthemes
--------------------
@todo


BOOTSTRAP FEATURE IMPLEMENTATIONS
----------------------------------------------------------------------
So far, the following Bootstrap features have been positively imple-
mented (see [1] for the authoritative list of features):

  1.  the basic fixed, 16-column grid system
  2.  typography and lists
  3.  basic form styles and buttons (including for the Webform
      module's forms)
  4.  topbar
  5.  tabs
  6.  breadcrumbs
  7.  block messages



THEME SETTINGS/FEATURES
----------------------------------------------------------------------
The theme's theme settings page, [3], automatically detects theme
regions whose names begin with either 'sidebar_' or 'row_', and
provides a form for assigning widths (e.g. 4/16, 8/16 etc) to ele-
ments.


Sidebar settings
--------------------
Use sliders to set widths of any number of columns--note that the
theme currently does NOT check to be sure that the values add up to
sixteen. Please confirm that they do!

Note also that you must manually add sidebars other than sidebar_first
and sidebar_second to the page.tpl.php file in your child theme.

As is usual in Drupal, the theme automatically hides any sidebars (or
other regions) which do not contain content. When this happens, the
theme's Content region will automatically be increased in size by the
size of the missing sidebar(s).


Row settings
--------------------
As with sidebars, the theme's settings page will provide a form field
for each region whose name begins with 'row_'. This field expects an
integer, and SETS THE WIDTHS OF THE BLOCKS CONTAINED IN THAT REGION.
The number of blocks that can fit in a region is equivalent to

  x / y
  
Where 'x' is the width of the region (in grid columns; usually this is
is 16), and 'y' is the value entered into the field. See the following
table for examples (assumes a 16 column grid):

Setting value         Blocks in row
--------------------  --------------------
  2                       8
  3                       3
  4                       4
  8                       2
  
So to display a row of four blocks side-by-side, set the value for row
width to 4, and add four blocks to the region.

There is currently no automatic method for setting asymmetrical rows
of blocks in this theme except to do it manually (i.e. in page.tpl.php
directly, or using the preprocess functions in template.php).

"Hero" unit
--------------------
Bootstrap includes a "Main hero unit for a primary marketing message
or call to action" [4]. This is essentially a big block, styled dif-
ferently from the main content. This theme implements that feature
by providing a region-specific block template, 
block--highlighted.tpl.php that provides the necessary class, and
changes the block's heading from h2 to h1. In page.tpl.php, when
$highlighted is set, the page's heading changes from h1 to h2 (i.e. so
that there is never more than a single h1 per page).

Use Drupal's Blocks interface or the Context module to display a 'hero
unit' on any (or every) page on your site. As it's a standard Drupal
region, it may contain any kind of block content whatsoever.


NOTES
----------------------------------------------------------------------
[1]   http://twitter.github.com/bootstrap/
[2]   http://lesscss.org/
[3]   admin/appearance/settings/bootstrap
[4]   bootstrap/examples/hero.html in this theme