﻿/*
 Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.dialog.add('smiley', function (a) {
    var b = a.config, c = a.lang.smiley, d = b.smiley_images, e = b.smiley_columns || 8, f, g, h = function (o) {
        var p = o.data.getTarget(), q = p.getName();
        if (q == 'a')p = p.getChild(0); else if (q != 'img')return;
        var r = p.getAttribute('cke_src'), s = p.getAttribute('title'), t = a.document.createElement('img', {
            attributes: {
                src: r,
                'data-cke-saved-src': r,
                title: s,
                alt: s,
                width: p.$.width,
                height: p.$.height
            }
        });
        a.insertElement(t);
        g.hide();
        o.data.preventDefault();
    }, i = CKEDITOR.tools.addFunction(function (o, p) {
        o = new CKEDITOR.dom.event(o);
        p = new CKEDITOR.dom.element(p);
        var q, r, s = o.getKeystroke(), t = a.lang.dir == 'rtl';
        switch (s) {
            case 38:
                if (q = p.getParent().getParent().getPrevious()) {
                    r = q.getChild([p.getParent().getIndex(), 0]);
                    r.focus();
                }
                o.preventDefault();
                break;
            case 40:
                if (q = p.getParent().getParent().getNext()) {
                    r = q.getChild([p.getParent().getIndex(), 0]);
                    if (r)r.focus();
                }
                o.preventDefault();
                break;
            case 32:
                h({data: o});
                o.preventDefault();
                break;
            case t ? 37 : 39:
            case 9:
                if (q = p.getParent().getNext()) {
                    r = q.getChild(0);
                    r.focus();
                    o.preventDefault(true);
                } else if (q = p.getParent().getParent().getNext()) {
                    r = q.getChild([0, 0]);
                    if (r)r.focus();
                    o.preventDefault(true);
                }
                break;
            case t ? 39 : 37:
            case CKEDITOR.SHIFT + 9:
                if (q = p.getParent().getPrevious()) {
                    r = q.getChild(0);
                    r.focus();
                    o.preventDefault(true);
                } else if (q = p.getParent().getParent().getPrevious()) {
                    r = q.getLast().getChild(0);
                    r.focus();
                    o.preventDefault(true);
                }
                break;
            default:
                return;
        }
    }), j = CKEDITOR.tools.getNextId() + '_smiley_emtions_label', k = ['<div><span id="' + j + '" class="cke_voice_label">' + c.options + '</span>', '<table role="listbox" aria-labelledby="' + j + '" style="width:100%;height:100%" cellspacing="2" cellpadding="2"', CKEDITOR.env.ie && CKEDITOR.env.quirks ? ' style="position:absolute;"' : '', '><tbody>'], l = d.length;
    for (f = 0; f < l; f++) {
        if (f % e === 0)k.push('<tr>');
        var m = 'cke_smile_label_' + f + '_' + CKEDITOR.tools.getNextNumber();
        k.push('<td class="cke_dark_background cke_centered" style="vertical-align: middle;"><a href="javascript:void(0)" role="option"', ' aria-posinset="' + (f + 1) + '"', ' aria-setsize="' + l + '"', ' aria-labelledby="' + m + '"', ' class="cke_smile cke_hand" tabindex="-1" onkeydown="CKEDITOR.tools.callFunction( ', i, ', event, this );">', '<img class="cke_hand" title="', b.smiley_descriptions[f], '" cke_src="', CKEDITOR.tools.htmlEncode(b.smiley_path + d[f]), '" alt="', b.smiley_descriptions[f], '"', ' src="', CKEDITOR.tools.htmlEncode(b.smiley_path + d[f]), '"', CKEDITOR.env.ie ? " onload=\"this.setAttribute('width', 2); this.removeAttribute('width');\" " : '', '><span id="' + m + '" class="cke_voice_label">' + b.smiley_descriptions[f] + '</span>' + '</a>', '</td>');
        if (f % e == e - 1)k.push('</tr>');
    }
    if (f < e - 1) {
        for (; f < e - 1; f++)k.push('<td></td>');
        k.push('</tr>');
    }
    k.push('</tbody></table></div>');
    var n = {
        type: 'html', html: k.join(''), onLoad: function (o) {
            g = o.sender;
        }, focus: function () {
            var o = this;
            setTimeout(function () {
                var p = o.getElement().getElementsByTag('a').getItem(0);
                p.focus();
            }, 0);
        }, onClick: h, style: 'width: 100%; border-collapse: separate;'
    };
    return {
        title: a.lang.smiley.title,
        minWidth: 270,
        minHeight: 120,
        contents: [{id: 'tab1', label: '', title: '', expand: true, padding: 0, elements: [n]}],
        buttons: [CKEDITOR.dialog.cancelButton]
    };
});
