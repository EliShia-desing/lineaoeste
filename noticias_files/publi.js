// 27/01/16
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
    var gads = document.createElement('script');
    gads.async = true;
    gads.type = 'text/javascript';
    var useSSL = 'https:' == document.location.protocol;
    gads.src = (useSSL ? 'https:' : 'http:') +
        '//www.googletagservices.com/tag/js/gpt.js';
    var node = document.getElementsByTagName('script')[0];
    node.parentNode.insertBefore(gads, node);
})();

googletag.cmd.push(function() {
    var mapping = googletag.sizeMapping().
        addSize([1024, 768], [[980, 90],[728, 90]]). // desktop
        addSize([980, 600], [[980, 90],[728, 90]]). // desktop
        addSize([747, 300], [[728, 90],[320, 50]] ). //tablet
        addSize([300, 240], [320, 50]). //mobile
        addSize([0, 0], []). //
        build();
    googletag.defineSlot('/3817/'+publiToken,[980, 90], 'Top').defineSizeMapping(mapping).addService(googletag.pubads());
	googletag.defineSlot('/3817/'+publiToken,[980, 90],[728, 90], 'Bottom').defineSizeMapping(mapping).addService(googletag.pubads());

    var mapping1 = googletag.sizeMapping().
        addSize([1024, 768], [300, 250]). // desktop
        addSize([980, 600], [300, 250]). // desktop
        addSize([747, 300], [300, 250]). //tablet
        addSize([300, 240], [300, 250]). //mobile
        addSize([0, 0], [300, 250]). //
        build();
    googletag.defineSlot('/3817/'+publiToken,[300, 250], 'Middle1').defineSizeMapping(mapping1).addService(googletag.pubads());
    googletag.defineSlot('/3817/'+publiToken,[300, 250], 'Middle2').defineSizeMapping(mapping1).addService(googletag.pubads());
	googletag.defineOutOfPageSlot('/3817/'+publiToken, 'Interstitial').addService(googletag.pubads());
    googletag.pubads().collapseEmptyDivs(true);
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
});