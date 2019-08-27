/* eslint-disable import/no-unresolved */

import Plugin from 'src/script/plugin-system/plugin.class';

let loadingScript = false;
let scriptLoaded = false;
const callbacks = [];

export default class SwagPaypalAbstractButtons extends Plugin {
    createScript(callback) {
        callbacks.push(callback);

        if (loadingScript) {
            if (scriptLoaded) {
                callback.call(this);
            }
            return;
        }

        loadingScript = true;
        const scriptOptions = this.getScriptUrlOptions();
        const payPalScriptUrl = `https://www.paypal.com/sdk/js?client-id=${this.options.clientId}${scriptOptions}`;
        const payPalScript = document.createElement('script');
        payPalScript.type = 'text/javascript';
        payPalScript.src = payPalScriptUrl;

        payPalScript.addEventListener('load', this.callCallbacks.bind(this), false);
        document.head.appendChild(payPalScript);
    }

    callCallbacks() {
        callbacks.forEach(callback => {
            callback.call(this);
        });

        scriptLoaded = true;
    }

    /**
     * @return {string}
     */
    getScriptUrlOptions() {
        let config = '';

        if (this.options.commit) {
            config += `&commit=${this.options.commit}`;
        }

        if (this.options.languageIso) {
            config += `&locale=${this.options.languageIso}`;
        }

        if (this.options.currency) {
            config += `&currency=${this.options.currency}`;
        }

        if (this.options.intent && this.options.intent !== 'sale') {
            config += `&intent=${this.options.intent}`;
        }

        config += '&components=marks,buttons';

        return config;
    }
}
