﻿/*
 Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

(function () {
    function a(d, e) {
        var f;
        try {
            f = d.getSelection().getRanges()[0];
        } catch (g) {
            return null;
        }
        f.shrink(CKEDITOR.SHRINK_TEXT);
        return f.getCommonAncestor().getAscendant(e, 1);
    };
    var b = {
        a: 'lower-alpha',
        A: 'upper-alpha',
        i: 'lower-roman',
        I: 'upper-roman',
        1: 'decimal',
        disc: 'disc',
        circle: 'circle',
        square: 'square'
    };

    function c(d, e) {
        var f = d.lang.list;
        if (e == 'bulletedListStyle')return {
            title: f.bulletedTitle,
            minWidth: 300,
            minHeight: 50,
            contents: [{
                id: 'info',
                accessKey: 'I',
                elements: [{
                    type: 'select',
                    label: f.type,
                    id: 'type',
                    style: 'width: 150px; margin: auto;',
                    items: [[f.notset, ''], [f.circle, 'circle'], [f.disc, 'disc'], [f.square, 'square']],
                    setup: function (h) {
                        var i = h.getStyle('list-style-type') || b[h.getAttribute('type')] || h.getAttribute('type') || '';
                        this.setValue(i);
                    },
                    commit: function (h) {
                        var i = this.getValue();
                        if (i)h.setStyle('list-style-type', i); else h.removeStyle('list-style-type');
                    }
                }]
            }],
            onShow: function () {
                var h = this.getParentEditor(), i = a(h, 'ul');
                i && this.setupContent(i);
            },
            onOk: function () {
                var h = this.getParentEditor(), i = a(h, 'ul');
                i && this.commitContent(i);
            }
        }; else if (e == 'numberedListStyle') {
            var g = [[f.notset, ''], [f.lowerRoman, 'lower-roman'], [f.upperRoman, 'upper-roman'], [f.lowerAlpha, 'lower-alpha'], [f.upperAlpha, 'upper-alpha'], [f.decimal, 'decimal']];
            if (!CKEDITOR.env.ie || CKEDITOR.env.version > 7)g.concat([[f.armenian, 'armenian'], [f.decimalLeadingZero, 'decimal-leading-zero'], [f.georgian, 'georgian'], [f.lowerGreek, 'lower-greek']]);
            return {
                title: f.numberedTitle,
                minWidth: 300,
                minHeight: 50,
                contents: [{
                    id: 'info',
                    accessKey: 'I',
                    elements: [{
                        type: 'hbox',
                        widths: ['25%', '75%'],
                        children: [{
                            label: f.start,
                            type: 'text',
                            id: 'start',
                            validate: CKEDITOR.dialog.validate.integer(f.validateStartNumber),
                            setup: function (h) {
                                var i = h.getAttribute('start') || 1;
                                i && this.setValue(i);
                            },
                            commit: function (h) {
                                h.setAttribute('start', this.getValue());
                            }
                        }, {
                            type: 'select',
                            label: f.type,
                            id: 'type',
                            style: 'width: 100%;',
                            items: g,
                            setup: function (h) {
                                var i = h.getStyle('list-style-type') || b[h.getAttribute('type')] || h.getAttribute('type') || '';
                                this.setValue(i);
                            },
                            commit: function (h) {
                                var i = this.getValue();
                                if (i)h.setStyle('list-style-type', i); else h.removeStyle('list-style-type');
                            }
                        }]
                    }]
                }],
                onShow: function () {
                    var h = this.getParentEditor(), i = a(h, 'ol');
                    i && this.setupContent(i);
                },
                onOk: function () {
                    var h = this.getParentEditor(), i = a(h, 'ol');
                    i && this.commitContent(i);
                }
            };
        }
    };
    CKEDITOR.dialog.add('numberedListStyle', function (d) {
        return c(d, 'numberedListStyle');
    });
    CKEDITOR.dialog.add('bulletedListStyle', function (d) {
        return c(d, 'bulletedListStyle');
    });
})();
