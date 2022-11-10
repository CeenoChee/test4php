function RangeFilter(obj) {
    var that = this;
    this.obj = obj;
    this.slider = this.obj.find('input');
    this.values = [];
    this.obj.find('.select-min option').each(function () {
        that.values.push($(this).prop('value').toString());
    });

    this.getMin = function () {
        var value = this.obj.find('select.select-min').val();
        if (value === null || typeof value == 'undefined') {
            return null;
        }
        return value.toString();
    }

    this.getMinLabel = function () {
        return this.obj.find('.select-min').find('option:selected').text();
    }

    this.getMinIndex = function () {
        return this.getIndexOf(this.getMin());
    }

    this.getIndexOf = function (value) {
        if (value === null) {
            return -1;
        }
        return this.values.indexOf(value.toString());
    }

    this.getMax = function () {
        var value = this.obj.find('select.select-max').val();
        if (value === null || typeof value == 'undefined') {
            return null;
        }
        return value.toString();
    }

    this.getMaxLabel = function () {
        return this.obj.find('.select-max').find('option:selected').text();
    }

    this.getMaxIndex = function () {
        return this.getIndexOf(this.getMax());
    }

    this.getTextValue = function () {
        return this.getMinLabel() + ' - ' + this.getMaxLabel();
    }

    this.onChange = function () {

    }

    this.onFinish = function () {

    }

    this.onUpdate = function () {

    }

    this.getOptions = function () {
        var options = [];
        this.obj.find('.select-min option').each(function () {
            var option = $(this);
            options.push({
                value: option.prop('value').toString(),
                label: option.text()
            });
        });
        return options;
    }

    this.updateRangeFilter = function (data) {
        if (data.from_value !== null && data.to_value !== null) {
            this.obj.find('.select-min').val(data.from_value.toString());
            this.obj.find('.select-max').val(data.to_value.toString());
            this.obj.find('.rangeInfo').html(this.getTextValue());
        }
    }

    var rangeValues = [];
    for (var i = 0; i < this.values.length; i++) {
        rangeValues.push(this.values[i]);
    }

    this.slider.ionRangeSlider({
        skin: 'round',
        type: 'double',
        hide_from_to: true,
        hide_min_max: true,
        values: rangeValues,
        from: that.getMinIndex(),
        to: that.getMaxIndex(),
        onStart: function () {
            that.obj.find('.rangeInfo').html(that.obj.find('select.select-min option:selected').text() + ' - ' + that.obj.find('select.select-max option:selected').text());
        },
        onChange: function (data) {
            that.updateRangeFilter(data);
            that.onChange();
        },
        onFinish: function (data) {
            that.updateRangeFilter(data);
            that.onFinish();
        },
        onUpdate: function (data) {
            that.updateRangeFilter(data);
            that.onUpdate();
        }
    });

    this.setValue = function (min, max) {

        var from = that.getIndexOf(min);
        var to = that.getIndexOf(max);

        if (from > -1 && to > -1) {
            this.slider.data("ionRangeSlider").update({
                from: from,
                to: to
            });
        }
    }

    this.clear = function () {
        if (this.values.length > 0) {
            this.slider.data("ionRangeSlider").update({
                from: 0,
                to: that.values.length - 1
            });
        }
    }

    this.obj.find('select').change(function () {
        that.setValue(that.getMin(), that.getMax());
        that.onChange();
    });

    this.isUsed = function () {
        if (this.values.length > 0) {
            if (this.getMin() != this.values[0] || this.getMax() != this.values[this.values.length - 1]) {
                return true;
            }
        }
        return false;
    }
}
