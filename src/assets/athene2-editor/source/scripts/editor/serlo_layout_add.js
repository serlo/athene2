/*global define*/
define([
    'jquery',
    'underscore',
    'cache',
    'events'
],
    function ($, _, Cache, eventScope) {
        "use strict";
        var LayoutAdd,
            imageCache = new Cache('athene2-editor-image');

        function createIconTag(columns) {
            var canvas = $('<canvas>')[0],
                context,
                width = 90,
                height = 60,
                gutter = 5,
                iterateX = 5,
                iconName = columns.toString(),
                cached = imageCache.remember() || {};


            function drawColumn(column) {
                var x = iterateX + gutter,
                    w = (width - 20 - 23 * gutter) / 24 * column + (column - 1) * gutter;

                iterateX += w + gutter;

                context.beginPath();
                context.fillStyle = '#C5C5C5';
                context.rect(x, 10, w, height - 20);
                context.fill();
            }


            function buildImageTag(dataURL, iconName) {
                return '<img src="' + dataURL + '" alt="' + iconName + '" />';
            }

            if (cached[iconName]) {
                return buildImageTag(cached[iconName], iconName);
            }

            canvas.width = width;
            canvas.height = height;

            context = canvas.getContext('2d');
            context.beginPath();
            context.fillStyle = '#EEEEEE';
            context.rect(0, 0, width, height);

            context.fill();

            _.each(columns, function (column, index) {
                drawColumn(column, index);
            });

            cached[iconName] = canvas.toDataURL("image/png");
            imageCache.memorize(cached);

            return buildImageTag(cached[iconName], iconName);
        }

        LayoutAdd = function (layouts) {
            var that = this;

            eventScope(that);

            that.$el = $('<div class="add-layout"></div>');
            that.$plus = $('<a href="#" class="plus">+</a>');
            that.$layoutList = $('<div class="layout-list">');

            _.each(layouts, function (columns) {
                var $addLayout = $('<a href="#">' + createIconTag(columns) + '</a>');

                $addLayout.click(function (e) {
                    e.stopPropagation();
                    that.trigger('add-layout', columns);
                    that.toggleLayouts(true);
                });

                that.$layoutList.append($addLayout);
            });

            that.$el.append(that.$plus);
            that.$plus.click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                that.toggleLayouts();
                return;
            });

            that.addEventListener('close', function () {
                that.toggleLayouts(true);
            });
        };

        LayoutAdd.prototype.toggleLayouts = function (forceClose) {
            if (forceClose || this.opened) {
                this.$layoutList.detach();
                this.opened = false;
            } else {
                this.$el.append(this.$layoutList);
                this.opened = true;
            }
        };

        return LayoutAdd;
    }
);