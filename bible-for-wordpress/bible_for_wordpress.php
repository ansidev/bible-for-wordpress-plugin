<?php 
/**
 * @package Bible for Wordpress
 * @author ansidev
 * @version 3.1
 */
/*
Plugin Name: Bible for Wordpress
Plugin URI: https://github.com/ansidev/bible-for-wordpress-plugin
Description: This plugin is used to get scripture from bible.com, compatible with Bible API version 3.1
Author: ansidev, (original authors: DanFrist and Jesse Lang)
Version: 3.1
Author URI: https://github.com/ansidev
Text Domain: bible-for-wordpress
*/
// Option names
define('BIBLE_DOT_COM_API_VERSION', '3.1');
define('BIBLE_DOT_COM_API_BASE_URI', 'https://events.bible.com/api/bible/versions/' . BIBLE_DOT_COM_API_VERSION);
define('BIBLE_VERSE_API_BASE_URI', 'https://events.bible.com/api/bible/verses/' . BIBLE_DOT_COM_API_VERSION);
define('BIBLE_TRANSLATION_OPT', 'BIBLE_TRANSLATION_OPTion');
define('BIBLE_DISPLAY_OPT', 'bible_display_option');
define("BIBLE_SHORTCODE", 'bible');
define('BIBLE_SHORTCODE_OT', '[' . BIBLE_SHORTCODE . ']');
define('BIBLE_SHORTCODE_CT', '[/' . BIBLE_SHORTCODE . ']');


function get_old_statement_books() {
    return array(
        'Genesis' => 'Gen',
        'Exodus' => 'Exo',
        'Leviticus' => 'Lev',
        'Numbers' => 'Num',
        'Deuteronomy' => 'Deu',
        'Joshua' => 'Jos',
        'Judges' => 'Jdg',
        'Ruth' => 'Rut',
        '1 Samuel' => '1Sa',
        '2 Samuel' => '2Sa',
        '1 Kings' => '1Ki',
        '2 Kings' => '2Ki',
        '1 Chronicles' => '1Ch',
        '2 Chronicles' => '2Ch',
        'Ezra' => 'Ezr',
        'Nehemiah' => 'Neh',
        'Esther' => 'Est',
        'Job' => 'Job',
        'Psalms' => 'Psa',
        'Proverbs' => 'Pro',
        'Ecclesiastes' => 'Ecc',
        'Song of Solomon' => 'Sng',
        'Isaiah' => 'Isa',
        'Jeremiah' => 'Jer',
        'Lamentations' => 'Lam',
        'Ezekiel' => 'Ezk',
        'Daniel' => 'Dan',
        'Hosea' => 'Hos',
        'Joel' => 'Jol',
        'Amos' => 'Amo',
        'Obadiah' => 'Oba',
        'Jonah' => 'Jon',
        'Micah' => 'Mic',
        'Nahum' => 'Nam',
        'Habakkuk' => 'Hab',
        'Zephaniah' => 'Zep',
        'Haggai' => 'Hag',
        'Zechariah' => 'Zec',
        'Malachi' => 'Mal'
    );
}

function get_new_statement_books() {
    return array(
        'Matthew' => 'Mat',
        'Mark' => 'Mrk',
        'Luke' => 'Luk',
        'John' => 'Jhn',
        'Acts' => 'Act',
        'Romans' => 'Rom',
        '1 Corinthians' => '1Co',
        '2 Corinthians' => '2Co',
        'Galatians' => 'Gal',
        'Ephesians' => 'Eph',
        'Philippians' => 'Php',
        'Colossians' => 'Col',
        '1 Thessalonians' => '1Th',
        '2 Thessalonians' => '2Th',
        '1 Timothy' => '1Ti',
        '2 Timothy' => '2Ti',
        'Titus' => 'Tit',
        'Philemon' => 'Phm',
        'Hebrews' => 'Heb',
        'James' => 'Jas',
        '1 Peter' => '1Pe',
        '2 Peter' => '2Pe',
        '1 John' => '1Jn',
        '2 John' => '2Jn',
        '3 John' => '3Jn',
        'Jude' => 'Jud',
        'Revelation' => 'Rev'
    );
}

function get_total_chapters() {
    return array(
        'Gen' => 50,
        'Exo' => 40,
        'Lev' => 27,
        'Num' => 36,
        'Deu' => 34,
        'Jos' => 24,
        'Jdg' => 21,
        'Rut' => 4,
        '1Sa' => 31,
        '2Sa' => 24,
        '1Ki' => 22,
        '2Ki' => 25,
        '1Ch' => 29,
        '2Ch' => 36,
        'Ezr' => 10,
        'Neh' => 13,
        'Est' => 10,
        'Job' => 42,
        'Psa' => 150,
        'Pro' => 31,
        'Ecc' => 12,
        'Sng' => 8,
        'Isa' => 66,
        'Jer' => 52,
        'Lam' => 5,
        'Ezk' => 48,
        'Dan' => 12,
        'Hos' => 14,
        'Jol' => 3,
        'Amo' => 9,
        'Oba' => 1,
        'Jon' => 4,
        'Mic' => 7,
        'Nam' => 3,
        'Hab' => 3,
        'Zep' => 3,
        'Hag' => 2,
        'Zec' => 14,
        'Mal' => 4,
        'Mat' => 28,
        'Mrk' => 16,
        'Luk' => 24,
        'Jhn' => 21,
        'Act' => 28,
        'Rom' => 16,
        '1Co' => 16,
        '2Co' => 13,
        'Gal' => 6,
        'Eph' => 6,
        'Php' => 4,
        'Col' => 4,
        '1Th' => 5,
        '2Th' => 3,
        '1Ti' => 6,
        '2Ti' => 4,
        'Tit' => 3,
        'Phm' => 1,
        'Heb' => 13,
        'Jas' => 5,
        '1Pe' => 5,
        '2Pe' => 3,
        '1Jn' => 5,
        '2Jn' => 1,
        '3Jn' => 1,
        'Jud' => 1,
        'Rev' => 22
    );
}

function get_all_statement_books() {
    $os_books = get_old_statement_books();
    $ns_books = get_new_statement_books();
    return array_merge($os_books, $ns_books);
}

// add a filter for all content to change bible tagged text into links
add_filter('the_content', 'bible_generate_links');
function bible_generate_links($text) {
    // If there is a bible tag in the text
    if (strpos($text, BIBLE_SHORTCODE_OT) !== false) {
        // Explode the text into an array
        $text = explode(BIBLE_SHORTCODE_OT, $text);

        // Loop through array
        foreach($text as $row) {
            // If this row has a
            if (strpos($row, BIBLE_SHORTCODE_CT) !== false) {
                // explode this return in case there is more text after the tag
                $row_exploded = explode(BIBLE_SHORTCODE_CT, $row);

                // trim away closing tag
                $row_exploded[0] = preg_replace('/\[\/'. BIBLE_SHORTCODE .'\].*/', '', $row_exploded[0]);

                // List of books and their abbreviations (OSIS)
                $books = array('Genesis' => 'Gen', 'Exodus' => 'Exo', 'Leviticus' => 'Lev', 'Numbers' => 'Num', 'Deuteronomy' => 'Deu', 'Joshua' => 'Jos', 'Judges' => 'Jdg', 'Ruth' => 'Rut', '1 Samuel' => '1Sa', '2 Samuel' => '2Sa', '1 Kings' => '1Ki', '2 Kings' => '2Ki', '1 Chronicles' => '1Ch', '2 Chronicles' => '2Ch', 'Ezra' => 'Ezr', 'Nehemiah' => 'Neh', 'Esther' => 'Est', 'Job' => 'Job', 'Psalms' => 'Psa', 'Proverbs' => 'Pro', 'Ecclesiastes' => 'Ecc', 'Song of Solomon' => 'Sng', 'Isaiah' => 'Isa', 'Jeremiah' => 'Jer', 'Lamentations' => 'Lam', 'Ezekiel' => 'Ezk', 'Daniel' => 'Dan', 'Hosea' => 'Hos', 'Joel' => 'Jol', 'Amos' => 'Amo', 'Obadiah' => 'Oba', 'Jonah' => 'Jon', 'Micah' => 'Mic', 'Nahum' => 'Nam', 'Habakkuk' => 'Hab', 'Zephaniah' => 'Zep', 'Haggai' => 'Hag', 'Zechariah' => 'Zec', 'Malachi' => 'Mal', 'Matthew' => 'Mat', 'Mark' => 'Mrk', 'Luke' => 'Luk', 'John' => 'Jhn', 'Acts' => 'Act', 'Romans' => 'Rom', '1 Corinthians' => '1Co', '2 Corinthians' => '2Co', 'Galatians' => 'Gal', 'Ephesians' => 'Eph', 'Philippians' => 'Php', 'Colossians' => 'Col', '1 Thessalonians' => '1Th', '2 Thessalonians' => '2Th', '1 Timothy' => '1Ti', '2 Timothy' => '2Ti', 'Titus' => 'Tit', 'Philemon' => 'Phm', 'Hebrews' => 'Heb', 'James' => 'Jas', '1 Peter' => '1Pe', '2 Peter' => '2Pe', '1 John' => '1Jn', '2 John' => '2Jn', '3 John' => '3Jn', 'Jude' => 'Jud', 'Revelation' => 'Rev');

                // change book name to abbreviated book name
                foreach($books as $key => $value) {
                    if (stristr($row_exploded[0], $key) !== false) {
                        $reference_link = str_replace($key, strtoupper($value).'.', $row_exploded[0]);
                        break;
                    } else if (stristr($row_exploded[0], $value) !== false) {
                        $reference_link = str_replace($value, strtoupper($value).'.', $row_exploded[0]);
                        break;
                    } 
                }
                // change : to /
                $reference_link = str_replace(':', '.', $reference_link);

                // get version if specified
                $last_dot = strrpos($reference_link, '.');
                $last_space = strrpos($reference_link, ' ', $last_dot + 1);

                if ($last_space === false) {
                    $translation_id = get_option(BIBLE_TRANSLATION_OPT);
                } else {
                    $version_length = strlen($reference_link) - $last_space - 1;
                    if ($version_length >= 3 && $version_length <= 6) {
                        $translation_id = strtolower(substr($reference_link, $last_space + 1));
                        $reference_link = substr($reference_link, 0, $last_space);
                    } else {
                        $translation_id = get_option(BIBLE_TRANSLATION_OPT);
                    }
                }

                $scripture_link = 'https://www.bible.com/bible/' . $translation_id . '/' . str_replace(' ', '', $reference_link);
                $reference_link = BIBLE_VERSE_API_BASE_URI . '?id=' . $translation_id .'&references[0]=' . str_replace(' ', '', $reference_link) . '&format=text';

                // Create request
                $request = wp_remote_get($reference_link);
                // Get response message
                $scripture = wp_remote_retrieve_body($request);
                // Decode message to PHP array.
                $scripture = json_decode($scripture, true);

                if (!$scripture['verses'][0]) {
                    $link = '<a target="_blank" href=' . $scripture_link . '>' . $row_exploded[0] . '</a>';
                } else {
                    $link = '<a target="_blank" href=' . $scripture_link . '>'. $scripture['verses'][0]['reference']['human'] . '</a>';
                }
                if (get_option(BIBLE_DISPLAY_OPT) == 'scripture') {
                    // put scripture in a blockquote tag
                    $row_exploded[0] = '<blockquote>' . $scripture['verses'][0]['content'] . ' (' . $link . ')</blockquote>';
                } else {
                    $row_exploded[0] = $link;
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
add_action('admin_enqueue_scripts', 'select2_enqueue_style');
function select2_enqueue_style() {
    wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css', array(), null); 
    wp_enqueue_script('jquery');
    wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array(), null, true);
}
 
function bible_config() {

    // set lang domain
    $plugin_dir = basename(dirname(__FILE__));
    load_plugin_textdomain('bible-for-wordpress', 'wp-content/plugins/'.$plugin_dir, $plugin_dir);

    // if settings have been posted
    if (isset($_POST[BIBLE_TRANSLATION_OPT])) {
        // if the option already exists, update it, else add it
        (get_option(BIBLE_TRANSLATION_OPT)) ? update_option(BIBLE_TRANSLATION_OPT, $_POST[BIBLE_TRANSLATION_OPT]) : add_option(BIBLE_TRANSLATION_OPT, $_POST[BIBLE_TRANSLATION_OPT]);

    }

    // if settings have been posted
    if (isset($_POST[BIBLE_DISPLAY_OPT])) {
        // if the option already exists, update it, else add it
        (get_option(BIBLE_DISPLAY_OPT)) ? update_option(BIBLE_DISPLAY_OPT, $_POST[BIBLE_DISPLAY_OPT]) : add_option(BIBLE_DISPLAY_OPT, $_POST[BIBLE_DISPLAY_OPT]);

    }
    // get current version of bible from db for selecting list item
    $current_bible_version = get_option(BIBLE_TRANSLATION_OPT);
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
                        <dt><label for=<?php echo BIBLE_TRANSLATION_OPT; ?>><?php _e("Bible Version:") ?></label></dt>
                        <dd>
                            <?php
                                $request_bible_version = wp_remote_get(esc_url_raw(BIBLE_DOT_COM_API_BASE_URI . "?type=all"));
                                // Get response message
                                $bible_versions = wp_remote_retrieve_body($request_bible_version);
                                // Decode message to PHP array.
                                $bible_versions = json_decode($bible_versions, true);
                                $bible_versions = $bible_versions['versions'];
                                $bible_data = array();
                                foreach ($bible_versions as $bible_version) {
                                    $lang = $bible_version['language']['name'];
                                    $id = $bible_version['id'];
                                    $version_data = array();
                                    $version_data['name'] = $bible_version['language']['name'];
                                    $version_data['abbreviation'] = $bible_version['abbreviation'];
                                    $version_data['title'] = $bible_version['title'];
                                    $bible_data[$lang][$id] = $version_data;
                                }
                                //print_r($bible_data);
?>
                            <select id=<?php echo BIBLE_TRANSLATION_OPT; ?> name=<?php echo BIBLE_TRANSLATION_OPT; ?> style="max-width:300px;" class="select2">
                                <?php foreach ($bible_data as $lang => $version_id) {
                                ?>
                                    <optgroup label=<?php _e('"' . $lang . '"');?>>
                                    <?php foreach ($version_id as $id => $version_data) { ?>
                                        <option value=<?php _e($id); if ($current_bible_version == $id) { _e(' selected="selected"'); } ?>><?php _e($version_data['abbreviation'] . " - " . $version_data['title']); ?></option>
                                    <?php } ?>
                                    </optgroup>
                                <?php } ?>
                            </select>
                        </dd>
                        <dt><label for="bible_display_type"><?php _e("Display Type:") ?></label></dt>
                        <dd>
                            <select id=<?php _e(BIBLE_DISPLAY_OPT) ?> name=<?php _e(BIBLE_DISPLAY_OPT) ?>>
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

            <p><strong><?php _e("Acceptable book names:"); ?></strong></p>

            <table>
                <tr>
                    <td valign="top" width="50%" style="padding-right:10px">
                        <p>
                            <i>Old Testament</i>
                            <hr/>
                            <?php
                                // List of old statement books and their abbreviations  (OSIS)
                                $os_books = get_old_statement_books();
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
                                $ns_books = get_new_statement_books();
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

// add bible to plugins list in admin
add_action('admin_menu', 'bible_config_page');
function bible_config_page() {
    // add bible to plugins list in admin
    if (function_exists('add_submenu_page')) {
        add_submenu_page('options-general.php', __('Bible for Wordpress'), __('Bible for Wordpress'), 'manage_options', 'bible-for-wordpress', 'bible_config');
    }
}



add_action('init', 'bible_for_wp_buttons');
function bible_for_wp_buttons() {
    add_filter( "mce_external_plugins", "bible_for_wp_add_buttons" );
    add_filter( 'mce_buttons', 'bible_for_wp_register_buttons' );
}
function bible_for_wp_add_buttons($plugin_array) {
    $plugin_array['bible_for_wp'] = plugins_url() . '/bible-for-wordpress/bible_for_wordpress.js';
    return $plugin_array;
}
function bible_for_wp_register_buttons($buttons) {
    array_push($buttons, 'bible_for_wp');
    return $buttons;
}

// add button to Wordpress Text Editor
function bible_shortcode_button_script() 
{
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
                
                // this function is used to retrieve the selected text from the text editor
                function getSelected()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton("bible_shortcode", "bible", callback);

                function callback()
                {
                    var bible_address = getSelected();
                    QTags.insertContent(<?php _e("'" . BIBLE_SHORTCODE_OT . "'"); ?> +  bible_address + <?php _e("'" . BIBLE_SHORTCODE_CT . "'"); ?>);
                }
            </script>
        <?php
    }
}

add_action("admin_print_footer_scripts", "bible_shortcode_button_script");
add_action( 'after_setup_theme', 'bible_setup' );
function bible_setup() {
    wp_enqueue_script( 'jquery-ui-dialog' );
    wp_enqueue_style( 'wp-jquery-ui-dialog' );
}
add_action( 'media_buttons', 'bible_button' );
function bible_button() {
    ?>
    <a href="#" id="insert-bible-verse" class="button">
        <span class="dashicons dashicons-book-alt"></span>
        Add Bible Verse
    </a>
    <?php
}
add_action( 'admin_head', 'bible_admin_styles' );
function bible_admin_styles() {
    // TODO: separate styles into .css files
    ?>
    <style type="text/css">
    #insert-bible-verse .dashicons {
        color: #82878c;
        font-size: 17px;
        margin-top: 5px;
    }
    .bible-dialog-actions {
        margin-top: 20px;
        text-align: right;
    }
    </style>
    <?php
}
add_action( 'admin_footer', 'bible_admin_scripts' );
function bible_admin_scripts() {
    // TODO: separate scripts into .js files
    ?>
    <div id="bible-dialog-wrapper" class="bible-dialog hidden" style="max-width:800px">
        <div class="bible-dialog-select">
            <select id="book" name="book" class="select2">
                <option value="">Book</option>
                <optgroup label="<?php _e('Old Statements');?>">
                <?php
                    $os_books = get_old_statement_books();
                    foreach ($os_books as $os_book_name => $os_book_code) { 
                ?>
                    <option value=<?php _e($os_book_code); ?>><?php _e($os_book_name); ?></option>
                <?php } ?>
                </optgroup>
                <optgroup label="<?php _e('New Statements');?>">
                <?php
                    $ns_books = get_new_statement_books();
                    foreach ($ns_books as $ns_book_name => $ns_book_code) { 
                ?>
                    <option value=<?php _e($ns_book_code); ?>><?php _e($ns_book_name); ?></option>
                <?php } ?>
                </optgroup>
            </select>

            <select id="chapter" name="chapter">
                <option value="">Chapter</option>

            </select>

            <select id="verse" name="verse">
                <option value="">Verse</option>
            </select>
        </div>
        <div class="bible-dialog-actions">
            <button id="bible-dialog-insert" class="button button-primary button-large">Insert</button>
            <button id="bible-dialog-cancel" class="button button-default button-large">Cancel</button>
        </div>
    </div>

    <script>
    (function ($) {
      $(document).ready(function () {
        var bibleDialog = $('#bible-dialog-wrapper');
        // Bible dialog config
        bibleDialog.dialog({
            title: 'Insert Bible Verse',
            dialogClass: 'wp-dialog',
            autoOpen: false,
            draggable: false,
            width: 'auto',
            modal: true,
            resizable: false,
            closeOnEscape: true,
            position: {
              my: "center",
              at: "center",
              of: window
            },
            open: function () {
              // close dialog by clicking the overlay behind it
              $('.ui-widget-overlay').bind('click', function(){
                $('#bible-dialog').dialog('close');
              })
            },
            create: function () {
              // style fix for WordPress admin
              $('.ui-dialog-titlebar-close').addClass('ui-button');
            },
        });
        // Open Bible dialog
        $('#insert-bible-verse').on('click', function () {
            bibleDialog.dialog('open');
        });
        // Cancel Bible dialog
        $('#bible-dialog-cancel').on('click', function () {
            bibleDialog.dialog('close');
        })
        var chapterList = <?php _e(json_encode(get_total_chapters())); ?>;
        $('#book').on('change', function () {
            var selectedBook = $('#book');
            var chapterSelect = $('#chapter');
            // Clear all chapter numbers
            chapterSelect.empty();
            var totalChapters = chapterList[selectedBook.val()] + 1;
            for (var i = 1; i < totalChapters; i++) {
                chapterSelect.append($('<option>', {
                    value: i,
                    text: i
                }));
            }
        });
        // Insert Bible
        $('#bible-dialog-insert').on('click', function () {
            var bookSelector = $('#book');
            var chapterSelector = $('#chapter');
            var verseSelector = $('#verse');
            var bibleAddress = bookSelector.val() + ' ' + chapterSelector.val() + ':' + verseSelector.val();
            tinymce.activeEditor.execCommand('mceInsertContent', false, bibleAddress);
            bibleDialog.dialog('close');
        });
      })
    })(jQuery);
    </script>
    <?php
}
?>