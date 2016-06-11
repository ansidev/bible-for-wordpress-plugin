# Bible for Wordpress Plugin
This plugin was forked from [YouVersion Wordpress Plugin](https://github.com/jesselang/youversion-wp-plugin "YouVersion Wordpress Plugin").

Plugin will retrive bible word from [Bible.com](https://bible.com/ "Bible.com") or print out reference link to original site.

Copyright 2010, 2012 by **Dan Frist** and **Jesse Lang** | License: **GPL v3**

Copyright 2016 by **ansidev** | License: **MIT**

### 1. Plugin Name

> Contributors: Dan Frist, Jesse Lang, ansidev 
> Tags: `bible`, `youversion`
> Requires at least: `2.0`
> Tested up to: `4.5.2`

### 2. Installation

1. Upload the `bible_for_wordpress.php` file to the `/wp-content/plugins/` directory.
2. Activate the plugin through the `Plugins` menu in WordPress.
3. Go to `Settings` > `Bible for Wordpress` to setting for plugin.

### 3. Instruction

##### **3.1 Instructions on How To Use the** `[bible]` **Tags**

The Bible for Wordpress plugin gives you the ability to quickly retrieve bible word or link to Bible verses using a simple tag structure that's familiar to Wordpress.

First, make sure to choose the **Bible version** and **display type** you want to use. You can change this setting later.

Second, when you create a new post or page on your Wordpress powered website, use this format **[bible]`Book name` `Chapter number` : `Sentence number`[/bible]** to create a reference with a link to that verse on [Bible.com](https://bible.com/ "Bible.com").

##### **3.2 Example:**

> In the text editor, type: `Hi, my name is Scott and [youversion]John 3:16[/youversion] is my favorite verse.`

> When you publish the post or page, it will look like: *Hi, my name is Scott and [John 3:16](https://www.bible.com/bible/151/john.3.16 "John 3:16") is my favorite verse.*

> Remember to spell the verse reference properly and use the commonly accepted format for Bible references (ie. John 3:16). The reference formats that work are "John 3:16" and "John 3:16-18".

> References that use commas (ie. John 3:16,18) or multi-chapter spans (ie. John 3:16-4:5) will not work and will result in a link that leads to a dead page on [Bible.com](https://bible.com/ "Bible.com").

##### **3.3 More information:**

You can also use abbreviation name for book name. Ex: `Gen` ~ `Genesis`. View all supported name in Plugin Settings Page.

Because of many bible versions, plugins support quick search bible version you want using [Select2](https://select2.github.io "Select2").

If you use only specific versions, you can customize plugin for your site.
