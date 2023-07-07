<style>
    #wallet-div { display:none;}
</style>
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

<style>
   .img-container.cropper-custom > img {
  display: block;

  /* This rule is very important, please don't ignore this */
  max-width: 100%;
  max-height: 300px;  
}

</style>

<form id="top-up-form" method='post' novalidate action="/action/top-up"  enctype="multipart/form-data">
    @csrf
<!-- Start row -->
<div class="row">

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                        <div class="mb-4 form-group">
                            <label class="form-label" for="form-sm-input">Select payment method</label>
                            <input   type="hidden"  name="funding_payment_method" id = "paymentmethod" value ="">
                            <div class="row payment-btn" id="payment_btn">
                                <div class="col-md-6 d-grid">
                                    <button type="button" class="btn btn-outline-primary waves-effect waves-light btn-lg mb-2" id="crypto">
                                        <i class="bx bx bx-bitcoin font-size-16 align-middle me-2"></i> Crypto 
                                    </button>
                                </div>
                                <div class="col-md-6 d-grid">
                                    <button type="button" class="btn btn-outline-primary waves-effect waves-light btn-lg mb-2" id="wallet">
                                        <i class="bx bx bx-wallet-alt font-size-16 align-middle me-2"></i>
                                        Wallet
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5 amount-input form-group">
                            <label class="form-label" for="default-input" data-pristine-required-message="Please Enter a amount">Enter the amount you wish to fund <b>($)</b></label>
                            <input class="form-control form-control-lg" required type="text" id="funding-amount" name="funding_amount" placeholder="00.00">
                        </div>
                    <div class="row" id="wallet-div">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <h4>Available Balance: <b>${{number_format((float)$availableBalance, 2, '.', '')}}</b></h4>                           
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            
        </div>
        <!-- end col -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <table>
                        <tr>
                            <td><label for="customRange1" class="form-label"> Your Fund with Service Charge </label></td>
                            <td><label class="span-font-size ml-20"> : <b id= "fund_with_service_charges"> $0.00</b></label></td>
                        </tr>
                        <tr>
                            <td><label for="customRange1" class="form-label"> Biz Service Charges </label></td>
                            <td><label class="span-font-size ml-20"> : <b id= "service_charges"> $10.00</b></label></td>
                        </tr>
                        <tr class="network_gas_fee">
                            <td><label for="customRange1" class="form-label"> Network Gas Fee </label></td>
                            <td><label class="span-font-size ml-20"> : <b id = "network_fee">$0.00</b></label></td>
                        </tr>
                        <tr>
                            <td><label for="customRange1" class="form-label"> Balance Funds for Trade </label></td>
                            <td><label class="span-font-size ml-20"> : <b id = "balance_funds_trade">$0.00</b></label></td>
                        </tr>
                        <tr>
                            <td><label for="customRange1" class="form-label"> Approximate Returns by Trades </label></td>
                            <td><label class="span-font-size ml-20"> : <b id = "approximate_returns">$0.00</b></label></td>
                        </tr>
                    </table>
                    <div class="alert alert-primary alert-outline fade show mb-0 top-up-alert" role="alert">
                        Please pay attention to the network gas fees. Always try to make your transactions via the networks 
                        that are more secure & with low gas fees, coz your funding amount will be decided always according 
                        to the received funds to the www.mytrader.biz wallets. If you select ERC20 it will cost you $5.
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-md-12">
            <div class="card" id="crypto-div">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4 form-group">
                                <label class="form-label" for="default-input">Currency Type</label>
                                <select class="form-select" name = "currency_type" id="currency_type" required>
                                    <option value="">Select a Currency Type</option>
                                    @foreach($currencytypes as $key => $currencytype)
                                        <option value="{{$currencytype->id}}">{{ $currencytype->title }}</option>
                                    @endforeach 
                                </select>
                              
                            </div>
                            <div class="mb-4 form-group">
                                <label class="form-label" for="default-input" >Crypto Network</label>
                                <select class="form-select" name = "network" id="network" required>
                                    <option value="">Select a Currency Type First </option>
                                </select>
                            </div>
                            <div class="mb-4 form-group">
                                <label class="form-label address_lable" for="default-input">Wallet Address</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" type="text" placeholder="Select a network and copy address" name="wallet_address" id="wallet_address" readonly>
                                    <div class="input-group-prepend">
                                        <span class="btn btn-primary waves-effect waves-light" id="copy_address">Copy</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-6 form-group">
                                <label class="form-label" for="default-input">Attach Payment Proof</label>
                                <div>
                                    <div class="fallback">
                                        <input name="payment_proof" type="file" id="image-chooser-top-up" required>
                                    </div>
                                        <div class="img-container cropper-custom mt-3">
                                                <img id="canvace_image" src="">
                                                     <div id="result-row">

                                                     </div>
                                                <div id="image_crop_btn" style="margin-top: 8px">        
                                        </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-5">
            <div class="card-body  text-right">
                <div class="form-group">                          
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="agree_disclaimer" id="agree_disclaimer" required>
                        <label class="form-check-label" for="agree_disclaimer">I here by agree to www.mytrader.biz <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> DISCLAIMER NOTICE.</a></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-5">
            <button type="submit" class="btn btn-primary waves-effect waves-light" >Submit</button>
        </div>
 
</div>
<!-- End row -->

</form>

<!-- Disclaimer Notice Modal start-->                                                                       
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="overflow-y: initial">
                      
            <div class="modal-body" style="height: 80vh; overflow-y: auto;">
                <div class="col-md-12">
                    <h5 id="staticBackdropLabel">Disclaimer Notice</h5>
                    <p>
                        Trading of International Stock Markets, Forex, Commodities & Crypto Currencies carries a high-level risk and at the same time, it is gaining high profits and may not be suitable for all kinds of entrepreneurs, investors or funders. Before deciding to fund www.mytrade.biz, you should be carefully considered the funding objectives, level of experience and risk appetite. And it’s better to get advice from a licensed financial advisor before taking your funding decisions.              
                    </p>
                    
                    <p>The possibility exists to lose some or all of the initial funds and therefore you shouldn't fund that you cannot afford to lose.</p>
                    
                    <p>
                        You should be aware of all the risks associated with high-level risk investments or funding, and you should've taken the advice of your independent financial adviser regarding the doubts before funding to www.mytrader.biz.  
                    </p>
                    
                    <p>
                        Any opinions, news, chats, research, analysis, prices or other information on this website is provided as general market information for getting a general understanding of the global market & educational purposes only. It does not constitute investment advice
                    </p>
                    
                    <p>
                        Www.mytrader.biz should not be relied upon as a substitute for extensive independent market research. Before making or getting any actual investment decisions, opinions, market data, recommendations or any other content is should be researched by yourself.
                    </p>
                    
                    <p>
                        The gains & losses will be changed according to high global market fluctuations, recessions, inflations, market manipulations, wars, and natural disasters & more incidents. Maybe totally you will lose your entire funds. Moreover, it would help if you always understood that the past performance of project www.mytrader.biz project is not necessarily indicative of future results.

                    </p>
                    
                    <p>
                        Www.mytrader.biz assures that it will be secured the personal information that you will provide to www.mytrader.biz when signing up. The personal information that www.mytrader.biz has given by you will not be linked with any other party. Also, your data will be protected if you follow the project engagement procedure accurately.
                    </p>
                    
                    <p>
                        If any platform that www.mytrader.biz is trading would be affected by a cyber-attack, it will be caused you to lose your money. The funds reclaiming processes may take a longer period or maybe it couldn't be reclaimed. Moreover, if any brokers or crypto exchanges went bankrupt, it may also be caused you to lose your money. The funds reclaiming processes may take a longer period or maybe it couldn't be reclaimed. You should understand the effects due to such incidents before funding. In addition, www.mytrader.biz will provide the relevant reports of platforms that were affected by the attack & realized lost funds in such cases
                    </p>
                    
                    <p>
                        Www.mytrader.biz is emphasized that www.mytrader.biz isn’t a finance company that is regulated by the relevant regulated parties. Www.mytrader.biz is a project that provides intraday trading services for the funders who request the service.  <p>
                    <p>
                        This service will be provided only by your 100% demand and www.mytrader.biz has no objectives to call for investments or funds from you for trading or any other activities. 
                    </p>

                    <p>
                        Moreover, you are confirming that you have read all the facts and understand the disclaimer here and that will abide by all those rules and regulations as stated by www.mytrader.biz. 
                    </p>

                    <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                        <i class="mdi mdi-check-all label-icon"></i>
                        By selecting & confirming this I ensure that funding in this www.mytrader.biz service is at my independent discretion & any of the other parties including mytrader.biz will not be responsible.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
            
        </div>
    </div>
</div>
<!-- Disclaimer Notice Modal End-->  

<script>
    var availableBalance = {{number_format((float)$availableBalance, 2, '.', '')}};
    var service_charges = {{number_format((float)$serviceCharge, 2, '.', '')}};
    var minimum_funding_amount = {{number_format((float)$minimumFundingAmount, 2, '.', '')}};
    var network_fee = 0;
    var curency_types = <?php echo json_encode($currencytypes);?>;
</script>




