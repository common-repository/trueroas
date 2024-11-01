/*-----------------------------
* Build Your Plugin JS / jQuery
-----------------------------*/
(function () {
    var _reroas = window._reroas = window._reroas || [];
      (function() {
        var u="https://app.trueroas.io/script/";
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.src=u+'reattributeScript.js'; s.parentNode.insertBefore(g,s);
        _reroas.push(['pixelId', TrueRoas.pixelID]);
        _reroas.push(['event', 'PageView']);
      })();
})();