function FilterBoxCheckboxGroup(filterBox, qSearchItem) {
    this.filterBox = filterBox;
    this.qSearchItem = qSearchItem;
    var that = this;

    this.init = function () {
        var contentBox = '';
        this.filterBox.obj.find('input.search-checkbox').each(function () {
            var checkbox = $(this);
            var id = checkbox.data('name') + '-' + checkbox.data('value');
            contentBox += '<div class="checkbox"><label for="' + id + '"><input type="checkbox" id="top-' + id + '" data-target="' + id + '" class="search-checkbox">' + checkbox.data('label') + '<span class="checkmark"></span></label>';
        });

        this.qSearchItem.setLabel(this.filterBox.obj.data('category-name'))
            .setValue(this.getValue())
            .setContentBox(contentBox);

        this.filterBox.obj.find('.checkbox').find('.search-checkbox').each(function () {
            var id = $(this).attr('id');
            $('#top-' + id).prop('checked', $('#' + id).prop('checked'));
        });

        this.filterBox.obj.find('.checkbox').click(function () {
            that.qSearchItem.setValue(that.getValue());
            that.qSearchItem.setShow(that.isUsed());

            var id = $(this).find('.search-checkbox').attr('id');
            var checkbox = $('#' + id);
            var topCheckbox = $('#top-' + id);
            topCheckbox.prop('checked', checkbox.prop('checked'));
            topCheckbox.click(function () {
                checkbox.prop('checked', topCheckbox.prop('checked'));
                that.filterBox.main.refreshUrl(false);
                UITimeout(function () {
                    that.filterBox.main.refreshProductCategory(false, false, false, true);
                });
            });

            that.filterBox.main.refreshUrl(false);
            UITimeout(function () {
                that.filterBox.main.refreshProductCategory(false, false, false, true);
            });
        });
    }

    this.getValue = function () {
        var value = [];
        this.filterBox.obj.find('.search-checkbox:checked').each(function () {
            var checkbox = $(this);
            value.push(checkbox.data('label'));
        });
        if (value.length > 0) {
            return value.join(', ');
        }
        return '';
    }

    this.isUsed = function () {
        return this.filterBox.obj.find('.search-checkbox:checked').length > 0;
    }

    this.clear = function () {
        this.filterBox.obj.find('.search-checkbox').prop('checked', false);
        $(this.qSearchItem.getContentBoxElement()).find('.search-checkbox').prop('checked', false);
        this.qSearchItem.setShow(false);
    }

    this.delete = function () {
        this.qSearchItem.delete();
    }

    this.init();
}

//-------------------------------------------------------------------------------------------

function FilterBoxRangeFilter(filterBox, qSearchItem) {
    this.filterBox = filterBox;
    this.qSearchItem = qSearchItem;

    var that = this;

    this.init = function () {
        var filter = this.filterBox.obj.find('.range-filter');


        this.rangeFilter = new RangeFilter(filter);

        var topId = 'top-' + this.filterBox.obj.data('category-id');


        var optionsHtml = '';

        var options = this.rangeFilter.getOptions();
        for (var i = 0; i < options.length; i++) {
            optionsHtml += '<option value="' + options[i].value + '">' + options[i].label + '</option>';
        }

        var contentBox = '<div class="range-filter"><div class="rangeInfo"></div><input type="hidden" id="' + topId + '"/><div class="minmax"><div>' +
            '<div class="label">Min</div><select class="form-control select-min">' + optionsHtml + '</select></div><div>' +
            '<div class="label">Max</div><select class="form-control select-max">' + optionsHtml + '</select></div></div>' +
            '</div>';

        this.qSearchItem.setLabel(this.filterBox.obj.data('category-name'))
            .setValue(this.getValue())
            .setContentBox(contentBox);

        this.topRangeFilter = new RangeFilter($('#' + topId).closest('.range-filter'));
        this.topRangeFilter.setValue(this.rangeFilter.getMin(), this.rangeFilter.getMax());

        this.rangeFilter.onChange = function () {
            that.qSearchItem.setValue(that.getValue());
            that.qSearchItem.setShow(that.isUsed());

            that.topRangeFilter.setValue(that.rangeFilter.getMin(), that.rangeFilter.getMax());

            UITimeout(function () {
                that.filterBox.main.refreshUrl(false);
                that.filterBox.main.refreshProductCategory(false, false, false, true);
            });
        }

        this.topRangeFilter.onChange = function () {
            that.qSearchItem.setValue(that.getValue());
            that.qSearchItem.setShow(that.isUsed());

            that.rangeFilter.setValue(that.topRangeFilter.getMin(), that.topRangeFilter.getMax());

            UITimeout(function () {
                that.filterBox.main.refreshUrl(false);
                that.filterBox.main.refreshProductCategory(false, false, false, true);
            });
        }
    }

    this.getValue = function () {
        if (this.isUsed()) {
            return this.rangeFilter.getTextValue();
        }
        return '';
    }

    this.isUsed = function () {
        return this.rangeFilter.isUsed();
    }

    this.clear = function () {
        this.rangeFilter.clear();
        this.topRangeFilter.clear();
        this.qSearchItem.setShow(false);
    }

    this.delete = function () {
        this.qSearchItem.delete();
    }

    this.init();
}

//-------------------------------------------------------------------------------------------

function FilterBox(main, obj) {
    this.main = main;
    this.obj = obj;
    this.filterButton = this.obj.find('.filter-button');
    var that = this;

    var component = null;

    //A filter tipusa
    this.getType = function () {
        return this.obj.data('type');
    }

    this.getTitle = function () {
        return this.obj.data('category-name');
    }

    //Filter inicializálása
    this.init = function () {
        switch (this.getType()) {
            case 'Intervallum':
            case 'val':
                this.component = new FilterBoxRangeFilter(this, this.createQSItem());
                break;
            case 'Felsorolt':
                this.component = new FilterBoxCheckboxGroup(this, this.createQSItem());
                break;
            case 'Logikai':
                this.component = new FilterBoxCheckboxGroup(this, this.createQSItem());
                break;
            default:
                console.log('Nem deffiniált filter doboz: ' + this.getTitle());
                this.component = null;
        }

        if (this.component !== null) {
            this.component.qSearchItem.setShow(this.isUsed());
        }
    }

    //Nyitva van a doboz?
    this.isOpen = function () {
        return this.obj.hasClass('active');
    }

    //Doboz kinyitása
    this.open = function () {
        if (!this.isOpen()) {
            this.obj.addClass('active');
        }
    }

    //Doboz bezárása
    this.close = function () {
        if (this.isOpen()) {
            this.obj.removeClass('active');
        }
    }

    //Doboz ki/be nyitása esemény
    this.filterButton.click(function () {
        if (that.isOpen()) {
            that.close();
        } else {
            that.open();
        }
    });

    this.getValue = function () {
        if (this.component) {
            return this.component.getValue();
        }
        return '';
    }

    //Van beállított érték
    this.isUsed = function () {
        return this.component.isUsed();
    }

    //Doboz beállításainak törlése
    this.clear = function () {
        this.component.clear();
        this.close();
    }

    //Visszaadja a felső szűrő azonosítóját.
    this.getQSId = function () {
        return 'qs_' + this.obj.data('category-id');
    }

    this.createQSItem = function () {
        var item = main.qSearch.createItem(this.getQSId());
        item.onClose = function () {
            that.clear();
            UITimeout(function () {
                that.main.refreshUrl(false);
                that.main.refreshProductCategory(false, false, false, true);
            });
        }
        return item;
    }

    this.delete = function () {
        if (this.component) {
            this.component.delete();
        }
    }

    this.init();
}

//-------------------------------------------------------------------------------------------

function ProductCategorySearch() {

    var that = this;
    this.qSearch = new QSearch('qsearch');
    this.dynamicFilterBoxes = [];

    //Termék kategória szűrő felület
    this.init = function () {

        this.initCatNav();

        this.qSearch.onAddKeywordItem = function () {
            $('#keywords').val(that.qSearch.getKeywords().join(','));
            that.refreshUrl(false);
            that.refreshProductCategory(false, false, false, true);
        }

        this.qSearch.onCloseItem = function () {
            $('#keywords').val(that.qSearch.getKeywords().join(','));
            that.refreshUrl(false);
            that.refreshProductCategory(false, false, false, true);
        }

        var keywords = $('#keywords').val()
        if (keywords != '') {
            keywords = keywords.split(',');
            for (var i = 0; i < keywords.length; i++) {
                this.qSearch.addKeywordItem(keywords[i]);
            }
        }

        $('#keyword, #min-ar, #max-ar').keyup(function () {
            that.refreshUrl(false);
            UITimeout(function () {
                that.refreshProductCategory(false, false, false, true);
            });
        });

        this.initBreadcrumb();

        this.initDynamicFilters();

        this.initProductCategoryList();

        window.onpopstate = function (e) {
            UITimeout(function () {
                that.refreshProductCategory(true, true, true, true);
            });
        }
    }

    this.openFirstBoxes = function () {
        $('.filter .filter-box').slice(0, 6).addClass('active');
    }

    this.setCategoryUrl = function (url) {
        $('#cat-nav').data('category-url', url);
    }

    this.initCatNav = function () {
        $('#cat-nav a').click(function (e) {
            e.preventDefault();

            that.setCategoryUrl($(this).prop('href'));
            that.refreshUrl(true);
            that.qSearch.deleteKeywords();
            that.refreshProductCategory(true, true, true, true);
        });
    }

    this.initBreadcrumb = function () {
        $('#breadcrumb a').click(function (e) {
            e.preventDefault();

            that.setCategoryUrl($(this).prop('href'));
            that.refreshUrl(true);
            that.refreshProductCategory(true, true, true, true);
        });
    }

    this.initDynamicFilters = function () {
        for (var i = 0; i < that.dynamicFilterBoxes.length; i++) {
            that.dynamicFilterBoxes[i].delete();
        }
        that.dynamicFilterBoxes = [];
        $('#dynamic-filters').find('.filter-box').each(function () {
            that.dynamicFilterBoxes.push(new FilterBox(that, $(this)));
        });

        this.openFirstBoxes();
    }

    //Szűrők értékeinek begyűjtése
    this.getPropertiesByUI = function () {
        var properties = {};

        //Kulcsszó
        if ($('#keywords').length && $('#keywords').val().length > 0) {
            properties['kulcsszo'] = $('#keywords').val();
        }

        //Rendezés
        if ($('.rendezes').length && $('.rendezes').val() != 'cikkszam') {
            if ($('.rendezes').val() !== null) {
                properties['rendezes'] = $('.rendezes').val();
            }
        }

        //Rendezés iránya
        if ($('.sort-order').length && $('.sort-order').data('value') == 'csokkeno') {
            if ($('.sort-order').data('value') !== null) {
                properties['rendezes-irany'] = 'csokkeno';
            }
        }

        //Találatok száma
        if ($('.talalatok-szama').length && $('.talalatok-szama').val() != 25) {
            if ($('.talalatok-szama').val() !== null) {
                properties['talalatok-szama'] = $('.talalatok-szama').val();
            }
        }

        //Checkbox-ok
        if ($('.filter .search-checkbox:checked').length > 0) {
            var checkboxValues = {};
            $('.filter .search-checkbox:checked').each(function () {
                var checkbox = $(this);
                var name = checkbox.data('name');
                var value = checkbox.data('value');

                if (value === true) {
                    value = 'true';
                } else if (value === false) {
                    value = 'false';
                } else if (value === null) {
                    value = 'null';
                }

                if (typeof (checkboxValues[name]) === 'undefined') {
                    checkboxValues[name] = [];
                }
                checkboxValues[name].push(value);
            });
            for (var name in checkboxValues) {
                properties[name] = checkboxValues[name].join('-');
            }
        }

        //Akciós termékek szűrése név alapján.

        if($('#akcios-true').prop('checked')) {
            if($('#on-sale').length) {
                properties['akcios'] = $('#on-sale').val();
            }
        }
        else {
            $('#on-sale').val('true');
        }

        //Fange filterm mezők
        $('.filter-box .range-filter').each(function () {
            var rangeFilter = $(this);

            var values = [];
            rangeFilter.find('.select-min option').each(function () {
                var option = $(this);
                values.push(option.prop('value'));
            });

            if (values.length > 0) {
                var minValue = rangeFilter.find('.select-min').val();
                var maxValue = rangeFilter.find('.select-max').val();

                if (minValue != values[0] || maxValue != values[values.length - 1]) {
                    var id = rangeFilter.find('input').attr('id');
                    properties[id] = minValue + '-' + maxValue;
                }
            }
        });

        return properties;
    }

    //A felület beállításaiból url-t csinál
    this.getUrlPropertiesByUI = function () {
        var properties = this.getPropertiesByUI();
        var url = '';
        for (var name in properties) {
            url += '&' + name + '=' + properties[name];
        }
        url = url.substr(1);
        if (url.length > 0) {
            return '?' + url;
        }
        return '';
    }

    //URL frissítése
    this.refreshUrl = function (clearProperties) {
        history.pushState(null, null, $('#cat-nav').data('category-url') + (clearProperties ? '' : this.getUrlPropertiesByUI()));
    }

    //Termékkategória lista eseményeinek inicializálása
    this.initProductCategoryList = function () {

        $('#product-category-list').product();

        /**
         * Lista rendezése
         */
        $('.rendezes').change(function () {
            $('.rendezes').val($(this).val());

            $('.sort-order').data('value', 'novekvo');

            that.refreshUrl(false);
            that.refreshProductCategory(false, false, false, true);
        });

        /**
         * Lista rendezése
         */
        $('.sort-order').click(function () {
            var value = $(this).data('value');
            if (value == 'novekvo') {
                value = 'csokkeno';
            } else {
                value = 'novekvo';
            }
            $('.sort-order').data('value', value);

            that.refreshUrl(false);
            that.refreshProductCategory(false, false, false, true);
        });

        /**
         * Találatok száma
         */
        $('.talalatok-szama').change(function () {
            $('.talalatok-szama').val($(this).val());

            that.refreshUrl(false);
            that.refreshProductCategory(false, false, false, true);
        });

        $('#product-category-list-pagination a').click(function (e) {
            e.preventDefault();

            var page = parseInt($(this).data('page'));

            var urlProperties = that.getUrlPropertiesByUI();
            if (page > 0) {
                if (urlProperties.length > 0) {
                    urlProperties += '&';
                } else {
                    urlProperties += '?';
                }
                urlProperties += 'page=' + page;
            }

            history.pushState(null, null, window.location.pathname + urlProperties);
            scrollTo('app');
            that.refreshProductCategory(false, false, false, page);
        });

        showFilterScrollBtn();
    }

    //Loading befejezése
    this.refreshProductCategoryEnd = function () {
        $('#breadcrumb').removeClass('loading');
        $('#cat-nav').removeClass('loading');
        $('#dynamic-filters').removeClass('loading');
        $('#product-category-list').removeClass('loading');
        $('#product-category-list-loading').hide();
    }

    //Felület frissítése
    this.refreshProductCategory = function (refreshNavigator, refreshBreadcrumb, refreshFilters, refreshProducts) {

        var categoryUrl = $('#cat-nav').data('category-url');

        var microtime = getMicrotime();
        $('#cat-nav').data('microtime', microtime);

        //POST adatok összerakása
        var data = {};
        data['microtime'] = microtime;

        data['refreshNavigator'] = refreshNavigator;
        data['refreshBreadcrumb'] = refreshBreadcrumb;
        data['refreshFilters'] = refreshFilters;

        if (refreshProducts) {
            data['refreshProducts'] = true;
        } else {
            data['refreshProducts'] = false;
        }

        if (Number.isInteger(refreshProducts)) {
            data['page'] = refreshProducts;
        }

        //A frissítendő blokkok megjelölése

        if (data['refreshNavigator']) {
            $('#cat-nav').addClass('loading');
        }

        if (data['refreshBreadcrumb']) {
            $('#breadcrumb').addClass('loading');
        }

        if (data['refreshFilters']) {
            $('#dynamic-filters').addClass('loading');
        }

        if (data['refreshProducts']) {
            $('#product-category-list').addClass('loading');
            $('#product-category-list-loading').show();
        }

        //Ajax hívás
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: data,
            success: function (result) {
                if (result.microtime == $('#cat-nav').data('microtime')) {

                    if (result.navigator) {
                        $('#cat-navigator-content').html(result.navigator);
                        that.initCatNav();
                    }

                    if (result.breadcrumb) {
                        $('#breadcrumb').html(result.breadcrumb);
                        that.initBreadcrumb();
                    }

                    if (result.filters) {
                        $('#dynamic-filters').html(result.filters);
                        that.initDynamicFilters();
                    }

                    if (result.productList) {
                        $('#product-category-list').html(result.productList);
                        that.initProductCategoryList();
                    }
                }
                that.refreshProductCategoryEnd();
            },
            error: function () {
                that.refreshProductCategoryEnd();
            },
            dataType: 'json'
        });
    }

    this.init();
}

function showFilterScrollBtn(){
    if($('#product-category-list').length){
        let lastFilterY = $('.filter-button:last').offset().top;
        let lastProductY = $('.prod-item:last').length ? $('.prod-item:last').offset().top + 350 : 350;
        let jumpBtn = $('#prod-jump-top');

        if (document.body.scrollTop > lastProductY || document.documentElement.scrollTop > lastProductY) {
            if (lastFilterY > lastProductY) {
                jumpBtn.removeClass('hidden');
            }
        } else {
            jumpBtn.addClass('hidden');
        }
    }
}


//-------------------------------------------------------------------------------------------

$(window).ready(function () {
    //Felület inicializálása
    if ($('#product-category-show').length) {
        new ProductCategorySearch();
    }

    $(document).scroll(function () {
        showFilterScrollBtn();
    });

    showFilterScrollBtn();
});
