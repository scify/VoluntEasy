@extends('default')

@section('title')
    Task Board
@stop

@section('pageTitle')
    Task Board
@stop

@section('bodyContent')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">

                    <div class="row bottom-margin statuses">
                        <div class="col-md-4">
                            <h3 class="panel-title">To Do</h3>
                        </div>
                        <div class="col-md-4">
                            <h3 class="panel-title">To Do</h3>
                        </div>
                        <div class="col-md-4">
                            <h3 class="panel-title">To Do</h3>
                        </div>
                    </div>

                    <div class="row board">
                        <div class="col-md-12">

                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                               aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                                Υποδοχή
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                                         aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="col-md-4 board-column">
                                                <div class="board-card draggable ui-widget-content">
                                                    <p>Μοίρασμα σοκολάτας</p>
                                                    <small class="text-left">12 εθελοντές</small>
                                                    <small class="text-right text-danger">31-jan</small>
                                                </div>
                                                <div class="board-card">
                                                    <p>Μοίρασμα σοκολάτας</p>
                                                    <small class="text-left">12 εθελοντές</small>
                                                    <small class="text-right text-danger">31-jan</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="board-card">
                                                    <p>Μοίρασμα σοκολάτας</p>
                                                    <small class="text-left">12 εθελοντές</small>
                                                    <small class="text-right text-danger">31-jan</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class="panel-title">Leggings occaecat craft beer farm-to-table, raw
                                                    denim aesthetic
                                                    synth nesciunt you probably haven't heard of them accusamus labore
                                                    sustainable VHS.</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Επικοινωνία
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                         aria-labelledby="headingTwo" aria-expanded="false">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard
                                            dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon
                                            tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore
                                            wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher
                                            vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic
                                            synth nesciunt you probably haven't heard of them accusamus labore
                                            sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseThree" aria-expanded="false"
                                               aria-controls="collapseThree">
                                                Ταμείο
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                         aria-labelledby="headingThree" aria-expanded="false">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard
                                            dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon
                                            tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore
                                            wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher
                                            vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic
                                            synth nesciunt you probably haven't heard of them accusamus labore
                                            sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary smallHeading mini-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">To Do</h3>
                </div>
                <div class="panel-body">
                    <code>.panel-success</code>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-info smallHeading mini-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Doing</h3>
                </div>
                <div class="panel-body">
                    <code>.panel-success</code>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-success smallHeading mini-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Done</h3>
                </div>
                <div class="panel-body">
                    <code>.panel-success</code>
                </div>
            </div>
        </div>
    </div>
--}}

@stop

@section('footerScripts')

    <script>
        $(".board-card").draggable({snap: ".statuses"});
        $( ".statuses" ).droppable({
            activeClass: "ui-state-default",
            hoverClass: "ui-state-hover",
            accept: ":not(.ui-sortable-helper)",
            drop: function( event, ui ) {
                $( this ).find( ".placeholder" ).remove();
                $( "<li></li>" ).text( ui.draggable.text() ).appendTo( this );
            }
        }).sortable({
            items: "li:not(.placeholder)",
            sort: function() {
                // gets added unintentionally by droppable interacting with sortable
                // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
                $( this ).removeClass( "ui-state-default" );
            }
        });

    </script>
@append