(function () {

    // Define our constructor
    this.Boxytree = function () {
        this.json = null;
        this.ul = null;
        this.container = '#boxytree';

        // Define option defaults
        var defaults = {
            url: 'http://volunteasy/api/tree',
            container: 'boxytree'
            //url: $("body").attr('data-url') + '/api/tree'
        }

        // Create options by extending defaults with the passed in arguments
        this.options = extendDefaults(defaults, arguments[0]);
    }

    Boxytree.prototype.init = function () {
        var base = this;

        $.when(ajax.call(base)).then(function (data, textStatus, jqXHR) {
            base.json = data;
            build.call(base);
        });
    }

    // Private Methods

    function ajax() {
        return $.ajax({
            url: this.options.url,
            method: 'GET'
        });
    }


    function build() {

        this.ul = $('<ul/>');

        var rootLi = $('<li/>')
            .text(this.json.description);

        rootLi.append(drawBranch(this.json.all_children));

        this.ul.append(rootLi);

        $(this.container).append(this.ul);
    }

    function drawBranch(children) {
        var ul = $('<ul/>');

        $.each(children, function (index, child) {
            var li =  $('<li/>').text(child.description);

            if (child.all_children.length > 0) {
                li.append(drawBranch(child.all_children));
                ul.append(li);
            }
            else
                ul.append(li);
        });

        return ul;
    }

    function extendDefaults(source, properties) {
        var property;
        for (property in properties) {
            if (properties.hasOwnProperty(property)) {
                source[property] = properties[property];
            }
        }
        return source;
    }

}());


var boxytree = new Boxytree();
boxytree.init();

