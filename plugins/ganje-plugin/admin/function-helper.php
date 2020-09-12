<?php
add_filter( 'ot_list_item_settings', 'filter_ot_list_item_settings', 10, 2 );
function filter_ot_list_item_settings( $settings, $id ) {
    $type = explode('_', $id);
    if ( $type[0] == 'txt' ) {

        $settings = array();
    }
    return $settings;
}

add_filter( 'ot_list_item_title_label', 'change_ot_list_item_label', 10, 2 );
function change_ot_list_item_label( $list_label, $list_id ) {

        $list_label = '';

    return $list_label;

}
add_filter('ot_social_links_description','change_ot_social_links_description',10 , 2);

function change_ot_social_links_description( $field_label, $field_id)
{
    $field_label = '';
    return $field_label;
}

/**
 * Get icons control default settings.
 *
 * Retrieve the default settings of the icons control. Used to return the default
 * settings while initializing the icons control
 */
function gnj_get_fontawesome_icon()
{
    return [ "abacus","acorn","ad","address-book","address-card","adjust","air-freshener","alarm-clock","alicorn","align-center","align-justify","align-left","align-right","allergies","ambulance","american-sign-language-interpreting","analytics","anchor","angel","angle-double-down","angle-double-left","angle-double-right","angle-double-up","angle-down","angle-left","angle-right","angle-up","angry","ankh","apple-alt","apple-crate","archive","archway","arrow-alt-circle-down","arrow-alt-circle-left","arrow-alt-circle-right","arrow-alt-circle-up","arrow-alt-down","arrow-alt-from-bottom","arrow-alt-from-left","arrow-alt-from-right","arrow-alt-from-top","arrow-alt-left","arrow-alt-right","arrow-alt-square-down","arrow-alt-square-left","arrow-alt-square-right","arrow-alt-square-up","arrow-alt-to-bottom","arrow-alt-to-left","arrow-alt-to-right","arrow-alt-to-top","arrow-alt-up","arrow-circle-down","arrow-circle-left","arrow-circle-right","arrow-circle-up","arrow-down","arrow-from-bottom","arrow-from-left","arrow-from-right","arrow-from-top","arrow-left","arrow-right","arrow-square-down","arrow-square-left","arrow-square-right","arrow-square-up","arrow-to-bottom","arrow-to-left","arrow-to-right","arrow-to-top","arrow-up","arrows","arrows-alt","arrows-alt-h","arrows-alt-v","arrows-h","arrows-v","assistive-listening-systems","asterisk","at","atlas","atom","atom-alt","audio-description","award","axe","axe-battle","baby","baby-carriage","backpack","backspace","backward","bacon","badge","badge-check","badge-dollar","badge-percent","badger-honey","balance-scale","balance-scale-left","balance-scale-right","ball-pile","ballot","ballot-check","ban","band-aid","barcode","barcode-alt","barcode-read","barcode-scan","bars","baseball","baseball-ball","basketball-ball","basketball-hoop","bat","bath","battery-bolt","battery-empty","battery-full","battery-half","battery-quarter","battery-slash","battery-three-quarters","bed","beer","bell","bell-school","bell-school-slash","bell-slash","bells","bezier-curve","bible","bicycle","binoculars","biohazard","birthday-cake","blanket","blender","blender-phone","blind","blog","bold","bolt","bomb","bone","bone-break","bong","book","book-alt","book-dead","book-heart","book-medical","book-open","book-reader","book-spells","book-user","bookmark","books","books-medical","boot","booth-curtain","bow-arrow","bowling-ball","bowling-pins","box","box-alt","box-ballot","box-check","box-fragile","box-full","box-heart","box-open","box-up","box-usd","boxes","boxes-alt","boxing-glove","brackets","brackets-curly","braille","brain","bread-loaf","bread-slice","briefcase","briefcase-medical","broadcast-tower","broom","browser","brush","bug","building","bullhorn","bullseye","bullseye-arrow","bullseye-pointer","burn","burrito","bus","bus-alt","bus-school","business-time","cabinet-filing","calculator","calculator-alt","calendar","calendar-alt","calendar-check","calendar-day","calendar-edit","calendar-exclamation","calendar-minus","calendar-plus","calendar-star","calendar-times","calendar-week","camera","camera-alt","camera-retro","campfire","campground","candle-holder","candy-cane","candy-corn","cannabis","capsules","car","car-alt","car-battery","car-bump","car-crash","car-garage","car-mechanic","car-side","car-tilt","car-wash","caret-circle-down","caret-circle-left","caret-circle-right","caret-circle-up","caret-down","caret-left","caret-right","caret-square-down","caret-square-left","caret-square-right","caret-square-up","caret-up","carrot","cart-arrow-down","cart-plus","cash-register","cat","cauldron","certificate","chair","chair-office","chalkboard","chalkboard-teacher","charging-station","chart-area","chart-bar","chart-line","chart-line-down","chart-network","chart-pie","chart-pie-alt","chart-scatter","check","check-circle","check-double","check-square","cheese","cheese-swiss","cheeseburger","chess","chess-bishop","chess-bishop-alt","chess-board","chess-clock","chess-clock-alt","chess-king","chess-king-alt","chess-knight","chess-knight-alt","chess-pawn","chess-pawn-alt","chess-queen","chess-queen-alt","chess-rook","chess-rook-alt","chevron-circle-down","chevron-circle-left","chevron-circle-right","chevron-circle-up","chevron-double-down","chevron-double-left","chevron-double-right","chevron-double-up","chevron-down","chevron-left","chevron-right","chevron-square-down","chevron-square-left","chevron-square-right","chevron-square-up","chevron-up","child","chimney","church","circle","circle-notch","city","claw-marks","clinic-medical","clipboard","clipboard-check","clipboard-list","clipboard-list-check","clipboard-prescription","clipboard-user","clock","clone","closed-captioning","cloud","cloud-download","cloud-download-alt","cloud-drizzle","cloud-hail","cloud-hail-mixed","cloud-meatball","cloud-moon","cloud-moon-rain","cloud-rain","cloud-rainbow","cloud-showers","cloud-showers-heavy","cloud-sleet","cloud-snow","cloud-sun","cloud-sun-rain","cloud-upload","cloud-upload-alt","clouds","clouds-moon","clouds-sun","club","cocktail","code","code-branch","code-commit","code-merge","coffee","coffee-togo","coffin","cog","cogs","coins","columns","comment","comment-alt","comment-alt-check","comment-alt-dollar","comment-alt-dots","comment-alt-edit","comment-alt-exclamation","comment-alt-lines","comment-alt-medical","comment-alt-minus","comment-alt-plus","comment-alt-slash","comment-alt-smile","comment-alt-times","comment-check","comment-dollar","comment-dots","comment-edit","comment-exclamation","comment-lines","comment-medical","comment-minus","comment-plus","comment-slash","comment-smile","comment-times","comments","comments-alt","comments-alt-dollar","comments-dollar","compact-disc","compass","compass-slash","compress","compress-alt","compress-arrows-alt","compress-wide","concierge-bell","container-storage","conveyor-belt","conveyor-belt-alt","cookie","cookie-bite","copy","copyright","corn","couch","cow","credit-card","credit-card-blank","credit-card-front","cricket","croissant","crop","crop-alt","cross","crosshairs","crow","crown","crutch","crutches","cube","cubes","curling","cut","dagger","database","deaf","debug","deer","deer-rudolph","democrat","desktop","desktop-alt","dewpoint","dharmachakra","diagnoses","diamond","dice","dice-five","dice-four","dice-one","dice-six","dice-three","dice-two","digital-tachograph","diploma","directions","disease","divide","dizzy","dna","do-not-enter","dog","dog-leashed","dollar-sign","dolly","dolly-empty","dolly-flatbed","dolly-flatbed-alt","dolly-flatbed-empty","donate","door-closed","door-open","dot-circle","dove","download","drafting-compass","dragon","draw-circle","draw-polygon","draw-square","dreidel","drum","drum-steelpan","drumstick","drumstick-bite","duck","dumbbell","dumpster","dumpster-fire","dungeon","ear","ear-muffs","eclipse","eclipse-alt","edit","egg","egg-fried","eject","elephant","ellipsis-h","ellipsis-h-alt","ellipsis-v","ellipsis-v-alt","empty-set","engine-warning","envelope","envelope-open","envelope-open-dollar","envelope-open-text","envelope-square","equals","eraser","ethernet","euro-sign","exchange","exchange-alt","exclamation","exclamation-circle","exclamation-square","exclamation-triangle","expand","expand-alt","expand-arrows","expand-arrows-alt","expand-wide","external-link","external-link-alt","external-link-square","external-link-square-alt","eye","eye-dropper","eye-evil","eye-slash","fast-backward","fast-forward","fax","feather","feather-alt","female","field-hockey","fighter-jet","file","file-alt","file-archive","file-audio","file-certificate","file-chart-line","file-chart-pie","file-check","file-code","file-contract","file-csv","file-download","file-edit","file-excel","file-exclamation","file-export","file-image","file-import","file-invoice","file-invoice-dollar","file-medical","file-medical-alt","file-minus","file-pdf","file-plus","file-powerpoint","file-prescription","file-signature","file-spreadsheet","file-times","file-upload","file-user","file-video","file-word","files-medical","fill","fill-drip","film","film-alt","filter","fingerprint","fire","fire-alt","fire-extinguisher","fire-smoke","fireplace","first-aid","fish","fish-cooked","fist-raised","flag","flag-alt","flag-checkered","flag-usa","flame","flask","flask-poison","flask-potion","flower","flower-daffodil","flower-tulip","flushed","fog","folder","folder-minus","folder-open","folder-plus","folder-times","folder-tree","folders","font","font-awesome-logo-full","football-ball","football-helmet","forklift","forward","fragile","french-fries","frog","frosty-head","frown","frown-open","function","funnel-dollar","futbol","gamepad","gas-pump","gas-pump-slash","gavel","gem","genderless","ghost","gift","gift-card","gifts","gingerbread-man","glass","glass-champagne","glass-cheers","glass-martini","glass-martini-alt","glass-whiskey","glass-whiskey-rocks","glasses","glasses-alt","globe","globe-africa","globe-americas","globe-asia","globe-europe","globe-snow","globe-stand","golf-ball","golf-club","gopuram","graduation-cap","greater-than","greater-than-equal","grimace","grin","grin-alt","grin-beam","grin-beam-sweat","grin-hearts","grin-squint","grin-squint-tears","grin-stars","grin-tears","grin-tongue","grin-tongue-squint","grin-tongue-wink","grin-wink","grip-horizontal","grip-lines","grip-lines-vertical","grip-vertical","guitar","h-square","hamburger","hammer","hammer-war","hamsa","hand-heart","hand-holding","hand-holding-box","hand-holding-heart","hand-holding-magic","hand-holding-seedling","hand-holding-usd","hand-holding-water","hand-lizard","hand-middle-finger","hand-paper","hand-peace","hand-point-down","hand-point-left","hand-point-right","hand-point-up","hand-pointer","hand-receiving","hand-rock","hand-scissors","hand-spock","hands","hands-heart","hands-helping","hands-usd","handshake","handshake-alt","hanukiah","hard-hat","hashtag","hat-santa","hat-winter","hat-witch","hat-wizard","haykal","hdd","head-side","head-side-brain","head-side-medical","head-vr","heading","headphones","headphones-alt","headset","heart","heart-broken","heart-circle","heart-rate","heart-square","heartbeat","helicopter","helmet-battle","hexagon","highlighter","hiking","hippo","history","hockey-mask","hockey-puck","hockey-sticks","holly-berry","home","home-alt","home-heart","home-lg","home-lg-alt","hood-cloak","horse","horse-head","hospital","hospital-alt","hospital-symbol","hospital-user","hospitals","hot-tub","hotdog","hotel","hourglass","hourglass-end","hourglass-half","hourglass-start","house-damage","house-flood","hryvnia","humidity","hurricane","i-cursor","ice-cream","ice-skate","icicles","id-badge","id-card","id-card-alt","igloo","image","images","inbox","inbox-in","inbox-out","indent","industry","industry-alt","infinity","info","info-circle","info-square","inhaler","integral","intersection","inventory","island-tropical","italic","jack-o-lantern","jedi","joint","journal-whills","kaaba","key","key-skeleton","keyboard","keynote","khanda","kidneys","kiss","kiss-beam","kiss-wink-heart","kite","kiwi-bird","knife-kitchen","lambda","lamp","landmark","landmark-alt","language","laptop","laptop-code","laptop-medical","laugh","laugh-beam","laugh-squint","laugh-wink","layer-group","layer-minus","layer-plus","leaf","leaf-heart","leaf-maple","leaf-oak","lemon","less-than","less-than-equal","level-down","level-down-alt","level-up","level-up-alt","life-ring","lightbulb","lightbulb-dollar","lightbulb-exclamation","lightbulb-on","lightbulb-slash","lights-holiday","link","lips","lira-sign","list","list-alt","list-ol","list-ul","location","location-arrow","location-circle","location-slash","lock","lock-alt","lock-open","lock-open-alt","long-arrow-alt-down","long-arrow-alt-left","long-arrow-alt-right","long-arrow-alt-up","long-arrow-down","long-arrow-left","long-arrow-right","long-arrow-up","loveseat","low-vision","luchador","luggage-cart","lungs","mace","magic","magnet","mail-bulk","mailbox","male","mandolin","map","map-marked","map-marked-alt","map-marker","map-marker-alt","map-marker-alt-slash","map-marker-check","map-marker-edit","map-marker-exclamation","map-marker-minus","map-marker-plus","map-marker-question","map-marker-slash","map-marker-smile","map-marker-times","map-pin","map-signs","marker","mars","mars-double","mars-stroke","mars-stroke-h","mars-stroke-v","mask","meat","medal","medkit","megaphone","meh","meh-blank","meh-rolling-eyes","memory","menorah","mercury","meteor","microchip","microphone","microphone-alt","microphone-alt-slash","microphone-slash","microscope","mind-share","minus","minus-circle","minus-hexagon","minus-octagon","minus-square","mistletoe","mitten","mobile","mobile-alt","mobile-android","mobile-android-alt","money-bill","money-bill-alt","money-bill-wave","money-bill-wave-alt","money-check","money-check-alt","monitor-heart-rate","monkey","monument","moon","moon-cloud","moon-stars","mortar-pestle","mosque","motorcycle","mountain","mountains","mouse-pointer","mug-hot","mug-marshmallows","music","narwhal","network-wired","neuter","newspaper","not-equal","notes-medical","object-group","object-ungroup","octagon","oil-can","oil-temp","om","omega","ornament","otter","outdent","pager","paint-brush","paint-brush-alt","paint-roller","palette","pallet","pallet-alt","paper-plane","paperclip","parachute-box","paragraph","parking","parking-circle","parking-circle-slash","parking-slash","passport","pastafarianism","paste","pause","pause-circle","paw","paw-alt","paw-claws","peace","pegasus","pen","pen-alt","pen-fancy","pen-nib","pen-square","pencil","pencil-alt","pencil-paintbrush","pencil-ruler","pennant","people-carry","pepper-hot","percent","percentage","person-booth","person-carry","person-dolly","person-dolly-empty","person-sign","phone","phone-office","phone-plus","phone-slash","phone-square","phone-volume","pi","pie","pig","piggy-bank","pills","pizza","pizza-slice","place-of-worship","plane","plane-alt","plane-arrival","plane-departure","play","play-circle","plug","plus","plus-circle","plus-hexagon","plus-octagon","plus-square","podcast","podium","podium-star","poll","poll-h","poll-people","poo","poo-storm","poop","popcorn","portrait","pound-sign","power-off","pray","praying-hands","prescription","prescription-bottle","prescription-bottle-alt","presentation","print","print-search","print-slash","procedures","project-diagram","pumpkin","puzzle-piece","qrcode","question","question-circle","question-square","quidditch","quote-left","quote-right","quran","rabbit","rabbit-fast","racquet","radiation","radiation-alt","rainbow","raindrops","ram","ramp-loading","random","receipt","rectangle-landscape","rectangle-portrait","rectangle-wide","recycle","redo","redo-alt","registered","repeat","repeat-alt","reply","reply-all","republican","restroom","retweet","retweet-alt","ribbon","ring","rings-wedding","road","robot","rocket","route","route-highway","route-interstate","rss","rss-square","ruble-sign","ruler","ruler-combined","ruler-horizontal","ruler-triangle","ruler-vertical","running","rupee-sign","rv","sack","sack-dollar","sad-cry","sad-tear","salad","sandwich","satellite","satellite-dish","sausage","save","scalpel","scalpel-path","scanner","scanner-keyboard","scanner-touchscreen","scarecrow","scarf","school","screwdriver","scroll","scroll-old","scrubber","scythe","sd-card","search","search-dollar","search-location","search-minus","search-plus","seedling","server","shapes","share","share-all","share-alt","share-alt-square","share-square","sheep","shekel-sign","shield","shield-alt","shield-check","shield-cross","ship","shipping-fast","shipping-timed","shish-kebab","shoe-prints","shopping-bag","shopping-basket","shopping-cart","shovel","shovel-snow","shower","shredder","shuttle-van","shuttlecock","sickle","sigma","sign","sign-in","sign-in-alt","sign-language","sign-out","sign-out-alt","signal","signal-alt","signal-alt-slash","signal-slash","signature","sim-card","sitemap","skating","skeleton","ski-jump","ski-lift","skiing","skiing-nordic","skull","skull-crossbones","slash","sledding","sleigh","sliders-h","sliders-h-square","sliders-v","sliders-v-square","smile","smile-beam","smile-plus","smile-wink","smog","smoke","smoking","smoking-ban","sms","snake","snow-blowing","snowboarding","snowflake","snowflakes","snowman","snowmobile","snowplow","socks","solar-panel","sort","sort-alpha-down","sort-alpha-up","sort-amount-down","sort-amount-up","sort-down","sort-numeric-down","sort-numeric-up","sort-up","soup","spa","space-shuttle","spade","spider","spider-black-widow","spider-web","spinner","spinner-third","splotch","spray-can","square","square-full","square-root","square-root-alt","squirrel","staff","stamp","star","star-and-crescent","star-christmas","star-exclamation","star-half","star-half-alt","star-of-david","star-of-life","stars","steak","steering-wheel","step-backward","step-forward","stethoscope","sticky-note","stocking","stomach","stop","stop-circle","stopwatch","store","store-alt","stream","street-view","stretcher","strikethrough","stroopwafel","subscript","subway","suitcase","suitcase-rolling","sun","sun-cloud","sun-dust","sun-haze","sunrise","sunset","superscript","surprise","swatchbook","swimmer","swimming-pool","sword","swords","synagogue","sync","sync-alt","syringe","table","table-tennis","tablet","tablet-alt","tablet-android","tablet-android-alt","tablet-rugged","tablets","tachometer","tachometer-alt","tachometer-alt-average","tachometer-alt-fast","tachometer-alt-fastest","tachometer-alt-slow","tachometer-alt-slowest","tachometer-average","tachometer-fast","tachometer-fastest","tachometer-slow","tachometer-slowest","taco","tag","tags","tally","tanakh","tape","tasks","tasks-alt","taxi","teeth","teeth-open","temperature-frigid","temperature-high","temperature-hot","temperature-low","tenge","tennis-ball","terminal","text-height","text-width","th","th-large","th-list","theater-masks","thermometer","thermometer-empty","thermometer-full","thermometer-half","thermometer-quarter","thermometer-three-quarters","theta","thumbs-down","thumbs-up","thumbtack","thunderstorm","thunderstorm-moon","thunderstorm-sun","ticket","ticket-alt","tilde","times","times-circle","times-hexagon","times-octagon","times-square","tint","tint-slash","tire","tire-flat","tire-pressure-warning","tire-rugged","tired","toggle-off","toggle-on","toilet","toilet-paper","toilet-paper-alt","tombstone","tombstone-alt","toolbox","tools","tooth","toothbrush","torah","torii-gate","tornado","tractor","trademark","traffic-cone","traffic-light","traffic-light-go","traffic-light-slow","traffic-light-stop","train","tram","transgender","transgender-alt","trash","trash-alt","trash-restore","trash-restore-alt","treasure-chest","tree","tree-alt","tree-christmas","tree-decorated","tree-large","tree-palm","trees","triangle","trophy","trophy-alt","truck","truck-container","truck-couch","truck-loading","truck-monster","truck-moving","truck-pickup","truck-plow","truck-ramp","tshirt","tty","turkey","turtle","tv","tv-retro","umbrella","umbrella-beach","underline","undo","undo-alt","unicorn","union","universal-access","university","unlink","unlock","unlock-alt","upload","usd-circle","usd-square","user","user-alt","user-alt-slash","user-astronaut","user-chart","user-check","user-circle","user-clock","user-cog","user-crown","user-edit","user-friends","user-graduate","user-hard-hat","user-headset","user-injured","user-lock","user-md","user-md-chat","user-minus","user-ninja","user-nurse","user-plus","user-secret","user-shield","user-slash","user-tag","user-tie","user-times","users","users-class","users-cog","users-crown","users-medical","utensil-fork","utensil-knife","utensil-spoon","utensils","utensils-alt","value-absolute","vector-square","venus","venus-double","venus-mars","vial","vials","video","video-plus","video-slash","vihara","volcano","volleyball-ball","volume","volume-down","volume-mute","volume-off","volume-slash","volume-up","vote-nay","vote-yea","vr-cardboard","walker","walking","wallet","wand","wand-magic","warehouse","warehouse-alt","watch","watch-fitness","water","water-lower","water-rise","wave-square","webcam","webcam-slash","weight","weight-hanging","whale","wheat","wheelchair","whistle","wifi","wifi-slash","wind","wind-warning","window","window-alt","window-close","window-maximize","window-minimize","window-restore","windsock","wine-bottle","wine-glass","wine-glass-alt","won-sign","wreath","wrench","x-ray","yen-sign","yin-yang", ];
}


