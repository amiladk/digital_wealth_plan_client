
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{$title}} </h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{$title}} </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-custom-padding">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Funding Amount ($)</th>
                            <th>Service Charge</th>
                            <th>Trading Amount</th>
                            <th>Funding Type</th>
                            <th>Funding Method</th>
                            <th>MOU</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($my_funding_payments)
                            @foreach($my_funding_payments as $funding)
                                <tr>
                                    <td>{{$funding->created_at}}</td>
                                    <td class="status-badge">
                                        @if($funding->status == 0)
                                            <span class="badge bg-info">Pending</span>
                                        @elseif($funding->status == 1)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger"> Not Approved</span>
                                        @endif
                                    </td>
                                    <td class="rigth-aligment"><?php echo number_format( $funding->funding_amount, 2, '.', ',');?></td>
                                    <td class="rigth-aligment"><?php echo number_format( $funding->service_charge, 2, '.', ',');?></td>
                                    <td class="rigth-aligment"><?php echo number_format( $funding->trading_amount, 2, '.', ',');?></td>
                                    <td >{{$funding->fundingTypeName()}}</td>
                                    <td >{{$funding->getFundingPaymentMethod->title}}</td>
                                    <td>
                                        <a {{$kyc_status==1 ? 'target=_blank href=/print-notice/'.$funding->id : 'data-bs-toggle=modal data-bs-target=#kyc-modal';}} class="btn btn-info waves-effect waves-light btn-sm">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end cardaa -->
    </div> <!-- end col -->
</div> <!-- end row -->


<div id="kyc-modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">KYC Approval Pending!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <p>Please get your KYC approved in order to view MOU.</p>
                </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a class="btn btn-primary" href="/kyc-verification">Go to KYC</a>
                    </div>
                </div>
            </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->