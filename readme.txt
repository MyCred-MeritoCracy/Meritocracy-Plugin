=== myCred Near Protocol ===
Contributors: mycred, wpexpertsio
Tags: mycred, crypto, nearprotocol, blockchain, points
Requires at least: 5.6
Tested up to: 5.8
Stable tag: 1.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

myCred Near Protocol is a plugin for WordPress that enables, users the ability to purchase mycred points from their Near Wallet. This plugin has its own settings and works independent of mycred-buycred addon.

== Setup ==
After plugin installation admin can add settings from 'myCred/General Settings/Near Protocol' admin will have to provide.

1. Near Protocol Network - default is testnet, other options are mainnet, betanet.
2. Admin NEAR Wallet Account - When users purchase myCred points, the near tokens will be transferred to admin
3. Exchange Rate - How many myCred Points are equal to 1 near token

After adding settings you will have to place shortcode [mnp_purchase_points] on the wp page where you want the form to appear.

= Plugin Requirements =

* [myCred 1.8+](https://wordpress.org/plugins/mycred/)
* WordPress 5.6+
* PHP 7.4+
* Near Wallet Account


== Installation ==

1. Go to Plugins > Add New.
2. Under Search, type myCred Learndash
3. Find myCred Learndash and click Install Now to install it
4. If successful, click Activate Plugin to activate it and you are ready to go.


== Changelog ==

= 1.0 =
Initial release
