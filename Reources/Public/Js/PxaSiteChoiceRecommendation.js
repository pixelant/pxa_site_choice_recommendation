PxaSiteChoiceRecommendation = function () {
    /**
     * Detect xhr
     *
     * @return {XMLHttpRequest|ActiveXObject}
     */
    function getXhr() {
        if (typeof XMLHttpRequest !== 'undefined') {
            return new XMLHttpRequest();
        }
        let versions = [
            "MSXML2.XmlHttp.6.0",
            "MSXML2.XmlHttp.5.0",
            "MSXML2.XmlHttp.4.0",
            "MSXML2.XmlHttp.3.0",
            "MSXML2.XmlHttp.2.0",
            "Microsoft.XmlHttp"
        ];

        let xhr;
        for (let i = 0; i < versions.length; i++) {
            try {
                xhr = new ActiveXObject(versions[i]);
                break;
            } catch (e) {
            }
        }

        return xhr;
    }

    /**
     * @constructor
     */
    function PxaSiteChoiceRecommendation()
    {
        this.ajaxUrl = '/?type=8790341';
    }

    let proto = PxaSiteChoiceRecommendation.prototype;

    /**
     * Load bar with ajax
     *
     * @param url
     * @param callback
     */
    proto.loadBar = function (url, callback) {
        url = url || this.ajaxUrl;

        let xhr = getXhr();

        xhr.addEventListener('load', function () {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
            }
        });

        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.send();
    };

    return PxaSiteChoiceRecommendation;
}();