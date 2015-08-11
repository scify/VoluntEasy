(function () {

    var base;

    // Define the constructor
    this.Treewrapper = function () {
        this.json = null;
        this.ul = null;
        this.container = '#treewrapper';

        // Define option defaults
        var defaults = {
            url: $("body").attr('data-url') + '/api/tree',
            container: 'treewrapper',
            active: {
                type: null,
                id: null
            },
            disabled: false

        }

        // Create options by extending defaults with the passed in arguments
        this.options = extendDefaults(defaults, arguments[0]);
    }

    //init the plugin
    Treewrapper.prototype.init = function () {
        base = this;

        $.when(ajax.call(base)).then(function (data, textStatus, jqXHR) {
            base.json = data;
            build.call(base);

            $("#tree").jOrgChart({
                chartElement: '#unitsTree',
                chartClass: "jOrgChart",
                disabled: base.options.disabled,
                children: base.options.children,
                multiple: base.options.multiple
            });

            if(base.options.create=='unit') {
                $(".node").click(function () {
                    if (!$(this).hasClass("disabled")) {
                        $("#parent_unit").val($(this).find(".description").text());
                        $("#parent_unit_id").val($(this).attr("data-id"));
                    }
                })
            }
            else if(base.options.create=='action') {
                $(".node.leaf").click(function () {
                    if (!$(this).hasClass("disabled")) {
                        $("#unit_id").val($(this).attr("data-id"));
                    }
                })
            }
        });

    }

    // Private Methods

    function ajax() {
        return $.ajax({
            url: this.options.url,
            method: 'GET'
        });
    }


    /**
     * Build the ul and lis
     */
    function build() {

        this.ul = $('<ul id="tree" style="display:none;"/>');

        var rootLi = $('<li/>')
            .text(this.json.description)
            .addClass(defineClasses(this.json));


        rootLi.append(drawBranch(this.json));

        this.ul.append(rootLi);

        $(this.container).append(this.ul);
    }

    /**
     * The recursive function that draws all the lis needed
     */
    function drawBranch(parent) {
        var ul = $('<ul/>');

        if (parent.all_children.length > 0) {
            $.each(parent.all_children, function (index, child) {
                var li = $('<li/>')
                    .text(child.description)
                    .addClass(defineClasses(child, 'unit'))
                    .attr('data-id', child.id);

                if (child.all_children.length > 0) {
                    li.append(drawBranch(child));
                    ul.append(li);
                }
                else if (child.actions.length > 0) {
                    $.each(child.actions, function (index, action) {
                        actionLi = $('<li/>')
                            .text(action.description)
                            .addClass('action')
                            .addClass(defineClasses(action, 'action'))
                            .attr('data-id', child.id);
                        li.append(actionLi);
                    });
                }
                else {
                    li.addClass('leaf');
                    ul.append(li);
                }
            });
        }
        return ul;
    }

    /**
     * Define the classes that the li should have.
     * For example, when creating a unit,
     * we should show only the units that the user has permission to edit
     * and do not have actions
     */
    function defineClasses(node, type) {

        var classString = '';

        if (base.options.create == 'unit') {
            classString += 'tooltips ';

            if (!node.permitted)
                classString += 'disabled notPermitted ';
            else if (node.all_actions.length > 0)
                classString += 'disabled hasActions ';
        }
        else if (base.options.create == 'action') {
            classString += 'tooltips ';

            if (!node.permitted)
                classString += 'disabled notPermitted ';
            else if (node.all_children.length > 0)
                classString += 'disabled hasUnits ';
        }

        if (base.options.active.type=='unit' && type=='unit') {
            if (node.id == base.options.active.id)
                classString += 'active-node ';
        }
       else if (base.options.active.type=='action' && type=='action') {
            if (node.id == base.options.active.id)
                classString += 'active-node ';
        }
        return classString;
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
