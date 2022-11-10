function QSearchItem(qSearch, id) {

    var that = this;
    this.qSearch = qSearch;
    this.id = id;
    this.type = 'item';
    this.label = '';
    this.value = '';
    this.show = false;
    this.openable = false;
    this.open = false;

    var element = document.createElement('div');
    element.classList.add('item');
    element.innerHTML = '<div class="content-box to-sky-500 text-xs p-2 rounded-md"></div>' +
        '<div class="content flex h-8 pl-2 leading-8 cursor-pointer mr-2 rounded-md bg-riel-dark text-white">' +
        '<div class="label"></div>' +
        '<div>:&nbsp;</div>' +
        '<div class="value font-semibold"></div>' +
        '<button class="close cursor-pinter block font-bold"></button></div>' +
        '';
    var items = this.qSearch.obj.querySelector('.items');
    items.insertBefore(element, items.childNodes[items.childNodes.length - 1]);

    this.obj = element;

    this.setType = function (type) {
        this.type = type;
        return this;
    }

    this.setLabel = function (label) {
        this.label = label;
        this.obj.querySelector('.label').innerText = label;
        return this;
    }

    this.setValue = function (value) {
        this.value = value;
        this.obj.querySelector('.value').innerText = value;
        return this;
    }

    //Kinyitja a vagy bezárja az elemet
    this.setOpen = function (open) {
        if (this.openable && open) {

            //Minden más item bezárása
            for (var i = 0; i < this.qSearch.items.length; i++) {
                if (this.qSearch.items[i].id != this.id) {
                    this.qSearch.items[i].setOpen(false);
                }
            }

            this.open = true;
            this.obj.querySelector('.content-box').classList.add('open');
        } else {
            this.open = false;
            this.obj.querySelector('.content-box').classList.remove('open');
        }
        return this;
    }

    //Eltűnteti az elemet
    this.setShow = function (show) {
        this.show = show;
        if (this.show) {
            this.obj.classList.add('show');
        } else {
            this.obj.classList.remove('show');
        }
        return this;
    }

    //Kinyithatóvá teszi az elemet
    this.setOpenable = function (openable) {
        if (!openable) {
            this.setOpen(false);
        }
        this.openable = openable;
        return this;
    }

    //Visszaadja az elem tartalmát
    this.getContentBoxElement = function () {
        return this.obj.querySelector('.content-box');
    }

    //Beállítja az elemt tartalmát
    this.setContentBox = function (contentBox) {
        this.getContentBoxElement().innerHTML = contentBox;
        this.setOpenable(contentBox != '')
        return this;
    }

    //Elemre kattintás esemény. Kinyitja vagy becsukja az elemet.
    this.obj.querySelector('.content').addEventListener("click", function () {
        if (that.openable) {
            that.setOpen(!that.open);
        }
    });

    this.onDelete = function () {

    }

    //Törli az elemet
    this.delete = function () {
        this.qSearch.deleteItem(this.id);
        this.onDelete();
    }

    this.onClose = function () {

    }

    //Bezárja az elemet. Nem törli csak eltűnteti az elemet.
    this.close = function () {
        this.setShow(false);
        this.onClose();
    }

    //A bezárás gombra kattintás esemány.
    this.obj.querySelector('.close').addEventListener("click", function () {
        that.close();
    });
}

function QSearch(id) {

    var that = this;
    this.id = id;
    this.obj = document.getElementById(this.id);
    this.obj.classList.add('qSearch');
    this.obj.innerHTML = '<div class="filter-tags relative pl-4 leading-10 border-2 border-solid border-neutral-200 flex p-2 bg-white rounded-md mt-4 xl:mt-0">' +
        '<div class="items flex flex-wrap gap-2">' +
        '<input type="text" class="keyword h-8" />' +
        '<div class="search-submit absolute z-10 text-riel-light top-0 left-0 pl-4 pr-2 bg-white"><i class="fa fa-search text-lg"></i></div>'+
        '</div>' +
        '</div>';

    this.placeholder = this.obj.getAttribute("data-placeholder");
    this.keyword = this.obj.getAttribute("data-keyword");

    this.items = [];

    this.keywordField = this.obj.querySelector('.keyword');
    this.keywordField.setAttribute("placeholder", this.placeholder);
    this.itemsObject = this.obj.querySelector('.items');

    //Ha rákattintunk a keresőre, akkor a fókusz a kulcsszó mezőre kerül. Elemekre kattintva ez nem történik meg.
    this.obj.querySelector('.filter-tags').addEventListener('click', function (event) {
        if (event.target == that.itemsObject) {
            that.keywordField.focus();
        }
    });

    //Megvizsgálja hogy a kereső tartalmaz egy elemet vagy sem.
    this.itemExists = function (id) {
        for (var i = 0; i < this.items.length; i++) {
            if (this.items[i].id == id) {
                return true;
            }
        }
        return false;
    }

    //Visszaadja a az elemet az azonosítója alapján.
    this.getItemById = function (id) {
        for (var i = 0; i < this.items.length; i++) {
            if (this.items[i].id == id) {
                return this.items[i];
            }
        }
        return null;
    }

    //Visszaadja egy elem indexét. -1-et ad vissza ha az elem nem létezik.
    this.getIndexOfItem = function (id) {
        for (var i = 0; i < this.items.length; i++) {
            if (this.items[i].id == id) {
                return i;
            }
        }
        return -1;
    }

    //Meghívódik ha bezárunk egy elemet
    this.onCloseItem = function () {

    }

    //Létrehoz egy elemet. Ha az elem már létezik akkor azt adja vissza.
    this.createItem = function (id) {
        var index = this.getIndexOfItem(id);
        if (index > -1) {
            return this.items[index];
        }
        var item = new QSearchItem(this, id);
        item.onClose = function () {
            that.onCloseItem();
        }
        this.items.push(item);
        return item;
    }

    //Meghívódik ha törlünk egy elemet.
    this.onDeleteItem = function () {

    }

    //Elem törlése
    this.deleteItem = function (id) {
        var index = this.getIndexOfItem(id);
        if (index > -1) {
            var obj = this.items[index].obj;
            obj.parentNode.removeChild(obj);
            this.items.splice(index, 1);
            this.onDeleteItem();
        }
    }

    //Meghívódik ha új kulcsó szűrőt adubk a keresőhöz
    this.onAddKeywordItem = function (item) {

    }

    //Létrehoz egy kulcsszó elemet
    this.addKeywordItem = function (keyword) {
        var item = this.createItem('keyword-' + this.getKeywords().length);
        item.setType('keyword');
        item.setLabel(this.keyword);
        item.setValue(keyword);
        item.setShow(true);
        item.onClose = function () {
            item.delete();
            that.onCloseItem();
        }
        this.onAddKeywordItem(item);
        return item;
    }

    //Visszaadja a kulcsszó elemeket.
    this.getKeywords = function () {
        var keywords = [];
        for (var i = 0; i < this.items.length; i++) {
            if (this.items[i].type == 'keyword') {
                keywords.push(this.items[i].value);
            }
        }
        return keywords;
    }

    //Törli a kulcsszavas mezőket
    this.deleteKeywords = function () {
        for (var i = 0; i < this.items.length; i++) {
            if (this.items[i].type == 'keyword') {
                this.deleteItem(this.items[i].id);
            }
        }
        return this;
    }

    //Meghívódik ha minden elem törölve lett.
    this.onClear = function () {

    }

    //Minden elemet töröl.
    this.clear = function () {
        for (var i = 0; i < this.items.length; i++) {
            this.items[i].obj.delete();
        }
        this.items = [];
        this.onClear();
        return this;
    }

    //Minden elemet bezár
    this.closeAll = function () {
        for (var i = 0; i < this.items.length; i++) {
            this.items[i].setOpen(false);
        }
        return this;
    }

    //Kulcsszó mezőben állva gomblenyomás figyelése.
    this.keywordField.addEventListener("keydown", function (e) {
        //Enter-re lézrehozzuk a kulcsszót ha van valami beírt szöveg.
        if (e.keyCode == 13) {
            e.preventDefault();
            if (that.keywordField.value.length > 0) {
                var item = that.addKeywordItem(that.keywordField.value);
                that.keywordField.value = '';
                that.closeAll();
            }
        }
    });
}
