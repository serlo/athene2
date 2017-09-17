/*global define*/
import $ from 'jquery';
import _ from 'underscore';
import eventScope from '../../libs/eventscope';
import t from '../../modules/translator';
import column_template from './templates/layout/column.html';

var Column,
  columnTemplate = _.template(column_template),
  emptyColumnHtml = '<p>' + t('Click to edit') + '</p>';

Column = function(width, data) {
  var that = this;
  eventScope(that);

  that.data = data || '';

  that.$el = $(
    columnTemplate({
      width: width
    })
  );

  that.type = width;

  // prevent links from being clicked
  that.$el.on('click', 'a', function(e) {
    e.preventDefault();
    return;
  });

  that.$el.click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    that.trigger('select', that);
    return;
  });
};

Column.prototype.update = function(data, html) {
  var patch;

  this.data = data;
  html = html && html !== '' ? html : emptyColumnHtml;

  patch = this.$el.quickdiff('patch', $('<div></div>').html(html), [
    'mathSpan',
    'mathSpanInline'
  ]);

  this.trigger('update', this);
  return patch;
};

Column.prototype.set = function(html) {
  this.$el.html(html || emptyColumnHtml);
};

Column.prototype.focus = function() {
  this.$el.focus().trigger('click');
};

export default Column;
