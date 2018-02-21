<?php 
/**
 * @package Bible for Wordpress
 * @author ansidev
 * @version 3.2
 */
/*
Plugin Name: Bible for Wordpress
Plugin URI: https://github.com/ansidev/bible-for-wordpress-plugin
Description: This plugin is used to get scripture from bible.com, compatible with Bible API version 3.1
Author: ansidev, (original authors: DanFrist and Jesse Lang)
Version: 3.2
Author URI: https://github.com/ansidev
Text Domain: bible-for-wordpress
*/
// Option names
define('BIBLE_DOT_COM_API_VERSION', '3.1');
define('BIBLE_DOT_COM_API_BASE_URI', 'https://nodejs.bible.com/api/bible');
define('BIBLE_VERSION_API_BASE_URI', BIBLE_DOT_COM_API_BASE_URI . '/versions/' . BIBLE_DOT_COM_API_VERSION);
define('BIBLE_VERSE_API_BASE_URI', BIBLE_DOT_COM_API_BASE_URI . '/verses/' . BIBLE_DOT_COM_API_VERSION);
define('BIBLE_TRANSLATION_ID', 'BIBLE_TRANSLATION_ID');
define('BIBLE_DISPLAY_OPT', 'BIBLE_DISPLAY_OPTION');
define("BIBLE_SHORTCODE_TAG", 'bible');
define('BIBLE_SHORTCODE_OT', '[' . BIBLE_SHORTCODE_TAG . ']');
define('BIBLE_SHORTCODE_CT', '[/' . BIBLE_SHORTCODE_TAG . ']');


function get_old_statement_books() {
    return array(
        'genesis' => 'gen',
        'exodus' => 'exo',
        'leviticus' => 'lev',
        'numbers' => 'num',
        'deuteronomy' => 'deu',
        'joshua' => 'jos',
        'judges' => 'jdg',
        'ruth' => 'rut',
        '1 samuel' => '1sa',
        '2 samuel' => '2sa',
        '1 kings' => '1ki',
        '2 kings' => '2ki',
        '1 chronicles' => '1ch',
        '2 chronicles' => '2ch',
        'ezra' => 'ezr',
        'nehemiah' => 'neh',
        'esther' => 'est',
        'job' => 'job',
        'psalms' => 'psa',
        'proverbs' => 'pro',
        'ecclesiastes' => 'ecc',
        'song of solomon' => 'sng',
        'isaiah' => 'isa',
        'jeremiah' => 'jer',
        'lamentations' => 'lam',
        'ezekiel' => 'ezk',
        'daniel' => 'dan',
        'hosea' => 'hos',
        'joel' => 'jol',
        'amos' => 'amo',
        'obadiah' => 'oba',
        'jonah' => 'jon',
        'micah' => 'mic',
        'nahum' => 'nam',
        'habakkuk' => 'hab',
        'zephaniah' => 'zep',
        'haggai' => 'hag',
        'zechariah' => 'zec',
        'malachi' => 'mal'
    );
}

function get_new_statement_books() {
    return array(
        'matthew' => 'mat',
        'mark' => 'mrk',
        'luke' => 'luk',
        'john' => 'jhn',
        'acts' => 'act',
        'romans' => 'rom',
        '1 corinthians' => '1co',
        '2 corinthians' => '2co',
        'galatians' => 'gal',
        'ephesians' => 'eph',
        'philippians' => 'php',
        'colossians' => 'col',
        '1 thessalonians' => '1th',
        '2 thessalonians' => '2th',
        '1 timothy' => '1ti',
        '2 timothy' => '2ti',
        'titus' => 'tit',
        'philemon' => 'phm',
        'hebrews' => 'heb',
        'james' => 'jas',
        '1 peter' => '1pe',
        '2 peter' => '2pe',
        '1 john' => '1jn',
        '2 john' => '2jn',
        '3 john' => '3jn',
        'jude' => 'jud',
        'revelation' => 'rev'
    );
}

function get_total_chapters() {
    return array(
        'gen' => 50,
        'exo' => 40,
        'lev' => 27,
        'num' => 36,
        'deu' => 34,
        'jos' => 24,
        'jdg' => 21,
        'rut' => 4,
        '1sa' => 31,
        '2sa' => 24,
        '1ki' => 22,
        '2ki' => 25,
        '1ch' => 29,
        '2ch' => 36,
        'ezr' => 10,
        'neh' => 13,
        'est' => 10,
        'job' => 42,
        'psa' => 150,
        'pro' => 31,
        'ecc' => 12,
        'sng' => 8,
        'isa' => 66,
        'jer' => 52,
        'lam' => 5,
        'ezk' => 48,
        'dan' => 12,
        'hos' => 14,
        'jol' => 3,
        'amo' => 9,
        'oba' => 1,
        'jon' => 4,
        'mic' => 7,
        'nam' => 3,
        'hab' => 3,
        'zep' => 3,
        'hag' => 2,
        'zec' => 14,
        'mal' => 4,
        'mat' => 28,
        'mrk' => 16,
        'luk' => 24,
        'jhn' => 21,
        'act' => 28,
        'rom' => 16,
        '1co' => 16,
        '2co' => 13,
        'gal' => 6,
        'eph' => 6,
        'php' => 4,
        'col' => 4,
        '1th' => 5,
        '2th' => 3,
        '1ti' => 6,
        '2ti' => 4,
        'tit' => 3,
        'phm' => 1,
        'heb' => 13,
        'jas' => 5,
        '1pe' => 5,
        '2pe' => 3,
        '1jn' => 5,
        '2jn' => 1,
        '3jn' => 1,
        'jud' => 1,
        'rev' => 22
    );
}
function get_max_chapter($bible_book_code) {
    $total_chapter = get_total_chapters();
    return $total_chapter[$bible_book_code];
}

function get_all_bible_books() {
    $books = get_old_statement_books();
    $ns_books = get_new_statement_books();
    foreach ($ns_books as $ns_book_name => $ns_book_code) {
        $books[$ns_book_name] = $ns_book_code;
    }
    return $books;
}

function get_bible_book_code(&$bible_book_name) {
    $lower_bible_book_name = strtolower($bible_book_name);
    $bible_books = get_all_bible_books();
    if (isset($bible_books[$lower_bible_book_name])) {
        $bible_book_name = ucwords($lower_bible_book_name);
        return $bible_books[$lower_bible_book_name];
    }
    $formatted_bible_book_name = preg_replace('/\s+/', '', $lower_bible_book_name);
    foreach ($bible_books as $bb_name => $bb_code) {
        if (preg_replace('/\s+/', '', $bb_name) === $formatted_bible_book_name) {
            $bible_book_name = ucwords($bb_name);
            return $bible_books[$bb_name];
        }
        if ($bb_code === $formatted_bible_book_name) {
            $bible_book_name = ucwords($bb_name);
            return $bb_code;
        }
    }
    return null;
}

function get_bible_translation_id() {
    if(!get_option('BIBLE_TRANSLATION_ID')){
        update_option('BIBLE_TRANSLATION_ID', 111);
    }
    return get_option(BIBLE_TRANSLATION_ID);
}

function get_bible_display_option() {
    if(!get_option('BIBLE_DISPLAY_OPT')){
        update_option('BIBLE_DISPLAY_OPT', 'scripture');
    }
    return get_option(BIBLE_DISPLAY_OPT);
}

function get_bible_scripture($bible_ref_link) {
    // Create request
    $request = wp_remote_get($bible_ref_link);
    // Get response message
    $scripture = wp_remote_retrieve_body($request);
    // Decode message to PHP array and return.
    return json_decode($scripture, true);
}

add_filter('the_content', 'parse_bible_shortcode');
function parse_bible_shortcode($text) {
    $bible_regex = '/(?:\[' . BIBLE_SHORTCODE_TAG . '\])(?:\s*)((?:\d\s*)?[a-zA-Z]+)(?:\s*)(\d+)(?:[:-]((?:\d+)?(?:(?:\s*)(?:[-,]\s*\d+)+)*)(:\d+|(?:\s*[A-Z]?[a-z]+\s*\d+:\d+))?(?:\s*))*(?:\[\/' . BIBLE_SHORTCODE_TAG . '\])/';
    $bible_book_group = 1;
    $bible_chapter_group = 2;
    $bible_verse_group = 3;

    preg_match_all($bible_regex, $text, $matches, PREG_OFFSET_CAPTURE);
    if (count($matches[0]) === 0) {
        return $text;
    }
    $deviation = 0;
    foreach ($matches[0] as $ref_index => $value) {
        $bible_book_name = $matches[$bible_book_group][$ref_index][0];
        $bible_book_code = get_bible_book_code($bible_book_name);
        if ($bible_book_code === NULL) {
            continue;
        }
        $bible_chapter = $matches[$bible_chapter_group][$ref_index][0];
        $bible_total_chapters = get_max_chapter($bible_book_code);
        if ($bible_chapter > $bible_total_chapters) {
            continue;
        }
        $raw_bible_verse_str = $matches[$bible_verse_group][$ref_index][0];
        $has_verse = strlen($raw_bible_verse_str) > 0;
        $reference = strtoupper($bible_book_code). "." . $bible_chapter;
        $reference_str = $reference;
        $bible_ref_text = $bible_book_name . " " . $bible_chapter;
        if ($has_verse) {
            $raw_bible_verses = explode(",", $raw_bible_verse_str);
            $bible_ref_text .= ":" . $raw_bible_verse_str;
            $reference_str .= "." . $raw_bible_verse_str;
        }
        $translation_id = get_bible_translation_id();
        $scripture_link = 'https://www.bible.com/bible/' . $translation_id . '/' . $reference_str;
        $scripture_link_code = '<a target="_blank" href=' . $scripture_link . '>' . $bible_ref_text . '</a>';
        if (get_bible_display_option() === "scripture") {
            $references = [];
            if ($has_verse) {
                foreach ($raw_bible_verses as $raw_bible_verse) {
                    if (preg_match('/(\d+)(?:\s*-\s*)(\d+)/', $raw_bible_verse, $bible_verse_range)) {
                        $start_verse = intval($bible_verse_range[1]);
                        $stop_verse = intval($bible_verse_range[2]);
                        $range = range($start_verse, $stop_verse);
                        foreach ($range as $verse_number) {
                            $references[] = $reference . "." . $verse_number;
                        }
                    } else {
                        $references[] = $reference . "." . intval($raw_bible_verse);
                    }
                }
            } else {
                $range = range(1, $bible_total_chapters);
                foreach ($range as $verse_number) {
                    $references[] = $reference . "." . $verse_number;
                }
            }
            sort($references);
            $bible_ref_link = BIBLE_VERSE_API_BASE_URI. "?".http_build_query(["id" => $translation_id, "references" => $references, "format" => "text"]);
            $scripture = get_bible_scripture($bible_ref_link);
            $verses_text = $scripture["verses"];
            $scripture_text = "";
            foreach ($verses_text as $verse) {
                $scripture_text .= $verse["content"] . " ";
            }
            $replacement = '<blockquote>' . $scripture_text . ' (' . $scripture_link_code . ')</blockquote>';
        } else {
            $replacement = $scripture_link_code;
        }
        $replace_length = strlen($value[0]);
        $start_pos = $value[1] + $deviation;
        $text = substr_replace($text, $replacement, $start_pos, $replace_length);
        $deviation += strlen($replacement) - $replace_length;
    }
    return $text;
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
    if (isset($_POST[BIBLE_TRANSLATION_ID])) {
        // if the option already exists, update it, else add it
        (get_option(BIBLE_TRANSLATION_ID)) ? update_option(BIBLE_TRANSLATION_ID, $_POST[BIBLE_TRANSLATION_ID]) : add_option(BIBLE_TRANSLATION_ID, $_POST[BIBLE_TRANSLATION_ID]);

    }

    // if settings have been posted
    if (isset($_POST[BIBLE_DISPLAY_OPT])) {
        // if the option already exists, update it, else add it
        (get_option(BIBLE_DISPLAY_OPT)) ? update_option(BIBLE_DISPLAY_OPT, $_POST[BIBLE_DISPLAY_OPT]) : add_option(BIBLE_DISPLAY_OPT, $_POST[BIBLE_DISPLAY_OPT]);

    }
    // get current version of bible from db for selecting list item
    $current_bible_version = get_option(BIBLE_TRANSLATION_ID);
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
                        <dt><label for=<?php echo BIBLE_TRANSLATION_ID; ?>><?php _e("Bible Version:") ?></label></dt>
                        <dd>
                            <?php
                                $request_bible_version = wp_remote_get(esc_url_raw(BIBLE_VERSION_API_BASE_URI . "?type=all"));
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
                            ?>
                            <select id=<?php echo BIBLE_TRANSLATION_ID; ?> name=<?php echo BIBLE_TRANSLATION_ID; ?> style="max-width:300px;" class="select2">
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
                                    echo "<code>".ucwords($key)."</code> or \t<code>".strtoupper($value)."</code><br><br>";
                                }
                            ?>
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
                                    echo "<code>".ucwords($key)."</code> or \t<code>".strtoupper($value)."</code><br><br>";
                                }
                            ?>
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
                    var bibleAddress = getSelected();
                    QTags.insertContent(<?php _e("'" . BIBLE_SHORTCODE_OT . "'"); ?> +  bibleAddress + <?php _e("'" . BIBLE_SHORTCODE_CT . "'"); ?>);
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
    #verse {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-top: 1px;
        padding: 5px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,.07);
        background-color: #fff;
        color: #32373c;
        line-height: 28px;
        height: 28px;
        width: 50px;
        vertical-align: bottom;
    }
    #verse:focus {
        border-color: #5b9dd9;
        outline: none;
        box-shadow: 0 0 2px rgba(30,140,190,.8);
        -webkit-box-shadow: 0 0 2px rgba(30,140,190,.8);
        -moz-box-shadow: 0 0 2px rgba(30,140,190,.8);
    }
    #chapter {
        width: 80px;
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
                    <option value=<?php _e($os_book_code); ?>><?php _e(ucwords($os_book_name)); ?></option>
                <?php } ?>
                </optgroup>
                <optgroup label="<?php _e('New Statements');?>">
                <?php
                    $ns_books = get_new_statement_books();
                    foreach ($ns_books as $ns_book_name => $ns_book_code) { 
                ?>
                    <option value=<?php _e($ns_book_code); ?>><?php _e(ucwords($ns_book_name)); ?></option>
                <?php } ?>
                </optgroup>
            </select>

            <select id="chapter" name="chapter">
                <option value="">Chapter</option>

            </select>

            <input id="verse" name="verse" placeholder="Verse number" required />
        </div>
        <div class="bible-dialog-actions">
            <button id="bible-dialog-insert" class="button button-primary button-large">Insert</button>
            <button id="bible-dialog-cancel" class="button button-default button-large">Cancel</button>
        </div>
    </div>

    <script>
    function isTinyMCEActive() {
        if (typeof(tinyMCE) == "undefined" || tinyMCE.activeEditor == null || tinyMCE.activeEditor.isHidden() != false) {
            return false;
        }
        return true;
    }
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
            }
        });
        // Open Bible dialog
        $('#insert-bible-verse').on('click', function () {
            bibleDialog.dialog('open');
        });
        // Cancel Bible dialog
        $('#bible-dialog-cancel').on('click', function () {
            bibleDialog.dialog('close');
        });
        var chapterList = <?php _e(json_encode(get_total_chapters())); ?>;
        $('#book').on('change', function () {
            var selectedBook = $('#book');
            var chapterSelect = $('#chapter');
            // Clear all chapter numbers
            chapterSelect.empty();
            var totalChapters = chapterList[selectedBook.val()];
            for (var i = 1; i <= totalChapters; i++) {
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
            var bibleAddress = <?php _e("'" . BIBLE_SHORTCODE_OT . "'"); ?> + bookSelector.val().toUpperCase() + ' ' + chapterSelector.val() + ':' + verseSelector.val() + <?php _e("'" . BIBLE_SHORTCODE_CT . "'"); ?>;

            if (isTinyMCEActive()) {
                tinyMCE.activeEditor.execCommand('mceInsertContent', false, bibleAddress);
            } else {
                QTags.insertContent(bibleAddress);
            }
            bibleDialog.dialog('close');
        });
      })
    })(jQuery);
    </script>
    <?php
}
?>