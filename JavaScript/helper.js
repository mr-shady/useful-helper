/**
 * update current page path params
 * if you pass undefined for index on add action the param will be added at the end of the path
 * @param index #array index
 * @param Action #add/update/remove/combine/subtract
 * @param Param #param name
 * @constructor
 */
 const UpdateParams = (index, Action, Param) => {
    let Path = window.location.pathname;
    let Params = Path.split("/").filter(v => v !== '');
    if (Action === 'add') {
        if (index === undefined) {
            Params.push(Param);
        } else {
            Params.splice(index, 0, Param);
        }
    } else if (Action === 'update') {
        Params[index] = Param;
    } else if (Action === 'combine') {
        Params[index] = Params[index] + Param;
    } else if (Action === 'subtract') {
        Params[index] = Params[index].replace(Param, '');
    } else if (Action === 'remove') {
        Params.splice(index, 1);
    }
    console.log(Params.filter(v => v !== '').join('/'));
    return Params.filter(v => v !== '').join('/');
}

/**
 * check if given parameter is numeric ro not
 * @param a
 * @returns {boolean}
 */
 let isNumeric = (a) => {
    return !isNaN(parseFloat(a)) && isFinite(a);
}

/**
 * check if given parameter is a function or not
 * @param o
 * @returns {boolean}
 */
 function isFunction(o) {
    return null !== o && "function" === typeof o && !!o.apply;
}

/**
 * redirect page to given url after given time
 * @param url
 * @param time
 * @constructor
 */
 const DelayedRedirect = (url, time) => {
    setTimeout(function () {
        window.location.href = url;
    }, time);
}

/**
 * Convert all \r and \n to <br /> tag like php nl2br()
 * @param str
 * @param is_xhtml
 * @returns {string}
 */
 let nl2br = (str, is_xhtml) => {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

/**
 * open url in new browser tab 
 * @param href
 */
 let openInNewTab = (href) => {
    Object.assign(document.createElement('a'), {
        target: '_blank',
        href: href,
    }).click();
};

/**
 * generate random string
 * @returns {number}
 */
 let uniqId = () => {
    return Math.round(new Date().getTime() + (Math.random() * 100));
};