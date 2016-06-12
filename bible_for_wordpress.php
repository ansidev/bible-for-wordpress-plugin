<?php 
/**
 * @package Bible for Wordpress
 * @author ansidev
 * @version 2.0
 */
/*
Plugin Name: Bible for Wordpress
Plugin URI: https://github.com/ansidev/bible-for-wordpress-plugin
Description: This plugin is used to get scripture from bible.com
Author: ansidev, (original authors: DanFrist and Jesse Lang)
Version: 2.0
Author URI: https://github.com/ansidev
Text Domain: bible-for-wordpress
*/
// Option names
define("BIBLE_VERSION_OPT", "bible_version_option");
define("BIBLE_DISPLAY_OPT", "bible_display_option");

function bible_generate_links($text) {
    // If there is a bible tag in the text
    if (strpos($text, '[bible]') !== false) {
        // Explode the text into an array
        $text = explode('[bible]', $text);

        // Loop through array
        foreach($text as $row) {
            // If this row has a
            if (strpos($row, '[/bible]') !== false) {
                // explode this return in case there is more text after the tag
                $row_exploded = explode('[/bible]', $row);

                // trim away closing tag
                $row_exploded[0] = preg_replace('/\[\/bible\].*/', '', $row_exploded[0]);

                // List of books and their abbreviations  (OSIS)
                $books = array('Genesis' => 'Gen', 'Exodus' => 'Exod', 'Leviticus' => 'Lev', 'Numbers' => 'Num', 'Deuteronomy' => 'Deut', 'Joshua' => 'Josh', 'Judges' => 'Judg', 'Ruth' => 'Ruth', '1 Samuel' => '1Sam', '2 Samuel' => '2Sam', '1 Kings' => '1Kgs', '2 Kings' => '2Kgs', '1 Chronicles' => '1Chr', '2 Chronicles' => '2Chr', 'Ezra' => 'Ezra', 'Nehemiah' => 'Neh', 'Esther' => 'Esth', 'Job' => 'Job', 'Psalms' => 'Ps', 'Proverbs' => 'Prov', 'Ecclesiastes' => 'Eccl', 'Song of Solomon' => 'Song', 'Isaiah' => 'Isa', 'Jeremiah' => 'Jer', 'Lamentations' => 'Lam', 'Ezekiel' => 'Ezek', 'Daniel' => 'Dan', 'Hosea' => 'Hos', 'Joel' => 'Joel', 'Amos' => 'Amos', 'Obadiah' => 'Obad', 'Jonah' => 'Jonah', 'Micah' => 'Mic', 'Nahum' => 'Nah', 'Habakkuk' => 'Hab', 'Zephaniah' => 'Zeph', 'Haggai' => 'Hag', 'Zechariah' => 'Zech', 'Malachi' => 'Mal', 'Matthew' => 'Matt', 'Mark' => 'Mark', 'Luke' => 'Luke', 'John' => 'John', 'Acts' => 'Acts', 'Romans' => 'Rom', '1 Corinthians' => '1Cor', '2 Corinthians' => '2Cor', 'Galatians' => 'Gal', 'Ephesians' => 'Eph', 'Philippians' => 'Phil', 'Colossians' => 'Col', '1 Thessalonians' => '1Thess', '2 Thessalonians' => '2Thess', '1 Timothy' => '1Tim', '2 Timothy' => '2Tim', 'Titus' => 'Titus', 'Philemon' => 'Phlm', 'Hebrews' => 'Heb', 'James' => 'Jas', '1 Peter' => '1Pet', '2 Peter' => '2Pet', '1 John' => '1John', '2 John' => '2John', '3 John' => '3John', 'Jude' => 'Jude', 'Revelation' => 'Rev');

                // change book name to abbreviated book name
                foreach($books as $key => $value) {
                    if (stristr($row_exploded[0], $key) !== false) {
                        $reference_link = str_replace($key, strtolower($value).'.', $row_exploded[0]);
                        break;
                    } else if (stristr($row_exploded[0], $value) !== false) {
                        $reference_link = str_replace($value, strtolower($value).'.', $row_exploded[0]);
                        break;
                    } 
                }
                // change : to /
                $reference_link = str_replace(':', '.', $reference_link);

                // get version if specified
                $last_dot = strrpos($reference_link, '.');
                $last_space = strrpos($reference_link, ' ', $last_dot + 1);

                if ($last_space === false) {
                    $version = get_option(BIBLE_VERSION_OPT);
                } else {
                    $version_length = strlen($reference_link) - $last_space - 1;
                    if ($version_length >= 3 && $version_length <= 6) {
                        $version = strtolower(substr($reference_link, $last_space + 1));
                        $reference_link = substr($reference_link, 0, $last_space);
                    } else {
                        $version = get_option(BIBLE_VERSION_OPT);
                    }
                }

                // remove any spaces
                $reference_link = 'http://bible.com/bible/'.$version.'/'.str_replace(' ', '', $reference_link);
				if (get_option(BIBLE_DISPLAY_OPT) == 'scripture') {
					// Create request
					$request = wp_remote_get($reference_link.'.json');
					// Get response message
					$scripture = wp_remote_retrieve_body($request);
					// Decode message to PHP array.
					$scripture = json_decode($scripture, true);
					// put scripture in a blockquote tag
                    $link = '<a target="_blank" href='.$reference_link.'>'.$scripture['human'].'</a>';
					$row_exploded[0] = '<blockquote>'.$scripture['reader_html'].' ('.$link.')</blockquote>';
				} else {
					// put the text in the tag in a link
					$row_exploded[0] = '<a target="_blank" href='.$reference_link.'>'.$row_exploded[0]. '</a>';
				}

                // put the link and any text after it back together
                $row = implode($row_exploded);

            }

            $output[] = $row;

        }

    } else {

        $output = $text;

    }

    // if this is an array (if text had a bible tag in it) put it back into a sting, else output string
    return (is_array($output)) ? implode($output) : $output;

}
// load css into the admin pages
function select2_enqueue_style() {
    wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css', array(), null); 
    wp_enqueue_script('jquery');
    wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array(), null, true);
}
add_action('admin_enqueue_scripts', 'select2_enqueue_style');
 
function bible_config() {


    // set lang domain
    $plugin_dir = basename(dirname(__FILE__));
    load_plugin_textdomain('bible-for-wordpress', 'wp-content/plugins/'.$plugin_dir, $plugin_dir);

    // if settings have been posted
    if (isset($_POST[BIBLE_VERSION_OPT])) {
        // if the option already exists, update it, else add it
        (get_option(BIBLE_VERSION_OPT)) ? update_option(BIBLE_VERSION_OPT, $_POST[BIBLE_VERSION_OPT]) : add_option(BIBLE_VERSION_OPT, $_POST[BIBLE_VERSION_OPT]);

    }

    // if settings have been posted
    if (isset($_POST[BIBLE_DISPLAY_OPT])) {
        // if the option already exists, update it, else add it
        (get_option(BIBLE_DISPLAY_OPT)) ? update_option(BIBLE_DISPLAY_OPT, $_POST[BIBLE_DISPLAY_OPT]) : add_option(BIBLE_DISPLAY_OPT, $_POST[BIBLE_DISPLAY_OPT]);

    }
    // get current version of bible from db for selecting list item
    $current_bible_version = get_option(BIBLE_VERSION_OPT);
    // get current display type from db for display scripture or link
	$current_display_type = get_option(BIBLE_DISPLAY_OPT);

    ?>
<h1><?php _e("Bible for Wordpress Plugin") ?></h1>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery(".select2").select2();	
    });
</script>
<table>
	<tr>
        <td valign="top">
            <p><strong><?php _e("Settings") ?></strong></p>
            <p>
                <form action="" method="post">
                    <dl>
                        <dt><label for=<?php echo BIBLE_VERSION_OPT; ?>><?php _e("Bible Version:") ?></label></dt>
                        <dd>
                            <?php
								$request_bible_version = wp_remote_get('https://www.bible.com/versions.json');
								// Get response message
								$bible_versions = wp_remote_retrieve_body($request_bible_version);
								// Decode message to PHP array.
								$bible_versions = json_decode($bible_versions, true);
								$bible_versions = $bible_versions['by_language'];
                                // print_r($bible_versions);
							?>
                            <select id=<?php echo BIBLE_VERSION_OPT; ?> name=<?php echo BIBLE_VERSION_OPT; ?> style="max-width:300px;" class="select2">
                                <?php foreach ($bible_versions as $lang_index => $language) {
                                    $label = esc_html($language['name']);
                                ?>
                                    <optgroup label=<?php _e('"'.$label.'"');?>>
                                    <?php foreach ($language['versions'] as $ver_index => $bible_version) { ?>
										<option value=<?php _e($bible_version['id']); if ($current_bible_version == $bible_version['id']) { _e(' selected="selected"'); } ?>><?php _e($bible_version['title']); ?></option>
                                    <?php } ?>
                                    </optgroup>
                                <?php } ?>
                            </select>
                        </dd>
                        <dt><label for="bible_display_type"><?php _e("Display Type:") ?></label></dt>
                        <dd>
                            <select id=<?php echo BIBLE_DISPLAY_OPT; ?> name=<?php echo BIBLE_DISPLAY_OPT; ?>>
                                <option value="link" <?php if ($current_display_type == 'link') echo 'selected="selected"'; ?>>Reference Link</option>
                                <option value="scripture" <?php if ($current_display_type == 'scripture') echo 'selected="selected"'; ?>>Scripture</option>
                            </select>
                        </dd>
                        <dt>
                            <input type="submit" value=<?php _e("Save Settings") ?>>
						</dt>
                    </dl>
                </form>

            </p>

            <hr />

            <p><strong><?php _e("Instructions on How To Use the [bible] Tags") ?></strong></p>

            <p><?php _e("The Bible for Wordpress plugin gives you the ability to quickly get Bible verses using a simple tag structure that's familiar to Wordpress.") ?></p>

            <p><?php _e("First, make sure to choose the Bible version you want all links to use. You can change this setting using the drop down list above.") ?></p>

            <p><?php echo sprintf(__("Second, when you create a new post or page on your Wordpress powered website, use this format %sPLAIN TEXT REFERENCE%s to create a reference with a link to that verse on Bible.com."), '<code>[bible]', '[/bible]</code>') ?></p>

            <p><strong><?php _e("Example:") ?></strong></p>

            <ul>
                <li><?php echo sprintf(__('In the text editor, type: "%sHi, my name is Scott and %s is my favorite verse.%s"'), '<em>', '[bible]John 3:16[/bible]', '</em>') ?></li>
                <li><?php echo sprintf(__('When you publish the post or page, it will look like: "%sHi, my name is Scott and %s is my favorite verse.%s"'), '<em>', '<a href="http://www.bible.com/bible/asv/john/3/16">John 3:16</a>', '</em>') ?></li>
            </ul>

            <p><?php _e('Remember to spell the verse reference properly and use the commonly accepted format for Bible references (ie. John 3:16). The reference formats that work are "John 3:16" and "John 3:16-18".') ?></p>

            <p><?php _e("References that use commas (ie. John 3:16,18) or multi-chapter spans (ie. John 3:16-4:5) will not work and will result in a link that leads to a dead page on Bible.com.com.") ?></p>

            <hr />

            <p><strong><?php _e("How to Grab the Bible.com Social Badge") ?></strong></p>

            <p><?php _e("Along with the Bible.com Wordpress plugin, we've created a simple-but-attractive badge (the Bible.com Social Badge) that you can embed in the sidebar of your blog or website. It can display your Bible.com avatar, username, the date you joined Bible.com, the number of followers you have on Bible.com, and your three most recent public Contributions.") ?></p>

            <p><?php echo sprintf(__("The Bible.com Social Badge is a great way to show your website visitors that you're an active member of the Bible.com community and easily share your Contributions in your sidebar. Go to %s to grab the Bible.com Social Badge."), '<a href="http://bible.com/badges">http://bible.com/badges</a>') ?></p>

        </td>
        <td width="10%" style="padding:0 20px; white-space:nowrap">

            <p><strong><?php _e("Acceptable book names:") ?></strong></p>

            <table>
                <tr>
                    <td valign="top" width="50%" style="padding-right:10px">
					<?php  ?>
                        <p>
                            <i>Old Testament</i>
                            <hr/>
							<?php
                                // List of old statement books and their abbreviations  (OSIS)
                                $os_books = array('Genesis' => 'Gen', 'Exodus' => 'Exod', 'Leviticus' => 'Lev', 'Numbers' => 'Num', 'Deuteronomy' => 'Deut', 'Joshua' => 'Josh', 'Judges' => 'Judg', 'Ruth' => 'Ruth', '1 Samuel' => '1Sam', '2 Samuel' => '2Sam', '1 Kings' => '1Kgs', '2 Kings' => '2Kgs', '1 Chronicles' => '1Chr', '2 Chronicles' => '2Chr', 'Ezra' => 'Ezra', 'Nehemiah' => 'Neh', 'Esther' => 'Esth', 'Job' => 'Job', 'Psalms' => 'Ps', 'Proverbs' => 'Prov', 'Ecclesiastes' => 'Eccl', 'Song of Solomon' => 'Song', 'Isaiah' => 'Isa', 'Jeremiah' => 'Jer', 'Lamentations' => 'Lam', 'Ezekiel' => 'Ezek', 'Daniel' => 'Dan', 'Hosea' => 'Hos', 'Joel' => 'Joel', 'Amos' => 'Amos', 'Obadiah' => 'Obad', 'Jonah' => 'Jonah', 'Micah' => 'Mic', 'Nahum' => 'Nah', 'Habakkuk' => 'Hab', 'Zephaniah' => 'Zeph', 'Haggai' => 'Hag', 'Zechariah' => 'Zech', 'Malachi' => 'Mal');
								foreach($os_books as $key => $value) {
									echo "<code>".$key."</code> or \t<code>".$value."</code><br><br>";
							}?>
                        </p>

                    </td>
                    <td valign="top" style="padding-left:10px">
						<p>
                            <i>New Testament</i>
							<hr/>
							<?php
                                // List of new statement books and their abbreviations  (OSIS)
                                $ns_books = array('Matthew' => 'Matt', 'Mark' => 'Mark', 'Luke' => 'Luke', 'John' => 'John', 'Acts' => 'Acts', 'Romans' => 'Rom', '1 Corinthians' => '1Cor', '2 Corinthians' => '2Cor', 'Galatians' => 'Gal', 'Ephesians' => 'Eph', 'Philippians' => 'Phil', 'Colossians' => 'Col', '1 Thessalonians' => '1Thess', '2 Thessalonians' => '2Thess', '1 Timothy' => '1Tim', '2 Timothy' => '2Tim', 'Titus' => 'Titus', 'Philemon' => 'Phlm', 'Hebrews' => 'Heb', 'James' => 'Jas', '1 Peter' => '1Pet', '2 Peter' => '2Pet', '1 John' => '1John', '2 John' => '2John', '3 John' => '3John', 'Jude' => 'Jude', 'Revelation' => 'Rev');
                                foreach($ns_books as $key => $value) {
									echo "<code>".$key."</code> or \t<code>".$value."</code><br><br>";
							}?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php 

}

function bible_config_page() {

    // add bible to plugins list in admin
    if (function_exists('add_submenu_page')) add_submenu_page('options-general.php', __('Bible for Wordpress'), __('Bible for Wordpress'), 'manage_options', 'bible-for-wordpress', 'bible_config');

}

// add a filter for all content to change bible tagged text into links
add_filter('the_content', 'bible_generate_links');

// add bible to plugins list in admin
add_action('admin_menu', 'bible_config_page');

?>