<?php
/**
 * Cehck Ajax Security Nonce
 */
function ganje_check_ajax_referer()
{
    $check_nonce = check_ajax_referer('thf_ajax_security_nonce', 'security', false);

    if (!$check_nonce || is_bot()) {
        if (wp_doing_ajax()) {
            wp_die(-1, 403);
        } else {
            die('-1');
        }
    }
}

/**
 * Check if the current request made by a known bot?
 */
function is_bot( $ua = null ) {

    if ( empty( $ua ) ) {
        $ua = $_SERVER['HTTP_USER_AGENT'];
    }

    $bot_agents = array(
        'alexa',
        'altavista',
        'ask jeeves',
        'attentio',
        'baiduspider',
        'bingbot',
        'chtml generic',
        'crawler',
        'fastmobilecrawl',
        'feedfetcher-google',
        'firefly',
        'froogle',
        'gigabot',
        'googlebot',
        'googlebot-mobile',
        'heritrix',
        'httrack',
        'ia_archiver',
        'irlbot',
        'iescholar',
        'infoseek',
        'jumpbot',
        'linkcheck',
        'lycos',
        'mediapartners',
        'mediobot',
        'motionbot',
        'msnbot',
        'mshots',
        'openbot',
        'pss-webkit-request',
        'pythumbnail',
        'scooter',
        'slurp',
        'Speed Insights',
        'snapbot',
        'spider',
        'taptubot',
        'technoratisnoop',
        'teoma',
        'twiceler',
        'yahooseeker',
        'yahooysmcm',
        'yammybot',
        'ahrefsbot',
        'Pingdom',
        'GTmetrix',
        'PageSpeed',
        'Google Page Speed',
        'kraken',
        'yandexbot',
        'twitterbot',
        'tweetmemebot',
        'openhosebot',
        'queryseekerspider',
        'linkdexbot',
        'grokkit-crawler',
        'livelapbot',
        'germcrawler',
        'domaintunocrawler',
        'grapeshotcrawler',
        'cloudflare-alwaysonline',
    );

    foreach ( $bot_agents as $bot_agent ) {
        if ( false !== stripos( $ua, $bot_agent ) ) {
            return true;
        }
    }

    return false;
}



function is_valid_mobile( $number ) {
    $patern = '/(0|\+98)?([ ]|,|-|[()]){0,2}9[0|1|2|3|4]([ ]|,|-|[()]){0,3}(?:[0-9]([ ]|,|-|[()]){0,2}){8}/';

    if ( preg_match( $patern, strval( $number ), $matches, PREG_OFFSET_CAPTURE, 0 ) )
        return true;

    return false;
}

/**
 * Add support for $args to the template part
 */
function gnj_get_template_part( $located, $args = array() ) {

    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    if ( !empty( $located ) && file_exists( $located ) ) {
        include( $located );
    }
}
