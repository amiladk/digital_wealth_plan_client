<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18 text-uppercase">{{$title}} </h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{$title}} </li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card geneology">
            <div class="d-flex flex-wrap gap-2 mx-auto ">
                <button type="button" class="btn btn-info waves-effect waves-light head-link" id="back-btn">Back</button>
                <button type="button" class="btn btn-success waves-effect waves-light" id="go-to-top">Go To Top</button>
                <span>
                    <div class="input-group auth-pass-inputgroup">
                        <input type="text" id="client" name="client" class="form-control" placeholder="Client Id" aria-label="Client" aria-describedby="client-addon">
                        <button class="btn btn-light shadow-none ms-0" type="button" id="client-addon">Search</button>
                    </div>
                </span>
            </div>
            <div class="card-body text-center">
                <a href="#" class="head-link" id="a-level-1">
                   <input type="hidden" id="top" name="top" value="">
                    <div class="card border border-primary level-1">
                        <div class="card-body">
                            <h5 class="card-title" id="level-1">
                            </h5>
                        </div>
                    </div>
                </a>

                <ol class="level-2-wrapper">
                    <li class="level2-li">
                        <a href="#" class="head-link" id="a-level-2-left">
                            <div class="card border border-primary level-2">
                                <div class="card-body">
                                    <h5 class="card-title" id="level-2-left">
                                    </h5>
                                </div>
                            </div>
                        </a>

                        <ol class="level-3-wrapper">
                            <li class="level3-li">
                                <a href="#" class="head-link" id="a-level-3-left-left">
                                    <div class="card border border-primary level-3">
                                        <div class="card-body">
                                            <h5 class="card-title" id="level-3-left-left">
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="level3-li">
                                <a href="#" class="head-link" id="a-level-3-left-right">
                                    <div class="card border border-primary level-3">
                                        <div class="card-body">
                                            <h5 class="card-title" id="level-3-left-right">
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ol>

                    </li>
                    <li class="level2-li">
                        <a href="#" class="head-link" id="a-level-2-right">
                            <div class="card border border-primary level-2">
                                <div class="card-body">
                                    <h5 class="card-title" id="level-2-right">
                                    </h5>
                                </div>
                            </div>
                        </a>

                        <ol class="level-3-wrapper">
                            <li class="level3-li">
                                <a href="#" class="head-link" id="a-level-3-right-left">
                                    <div class="card border border-primary level-3">
                                        <div class="card-body">
                                            <h5 class="card-title" id="level-3-right-left">
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="level3-li">
                                <a href="#" class="head-link" id="a-level-3-right-right">
                                    <div class="card border border-primary level-3">
                                        <div class="card-body">
                                            <h5 class="card-title" id="level-3-right-right">
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ol>

                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<script>
    var client_id={{Auth::user()->id}};
</script>