<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Discalimer Notice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap');

        .body{
            padding: 0;
            margin: 0;
        }

        h1, h2, h3, h4, h5, h6, p{
            font-family: 'Lato', Helvetica, sans-serif;
        }

        p, th, td{
            font-size: 12px;
        }

        .notice p, .notice ul li{
            text-align: justify;
            padding-left: 10px 0;
        }

        .img-div{
            text-align: left
        }

        .address{
            text-align: right;
        }

        .invoice{
            background-color: rgb(236, 236, 236);
            margin: 10px 0; 
        }

        .details{
            text-align: left;
            padding: 10px
        }

        .amount{
            text-align: right;
            padding: 10px
        }

    </style>

<script>
    window.onload = function(){
        window.print();
    }
</script>

  </head>

  <body>

        <div class="container-fluid">
            <div class="row">
                <div class="col-6 img-div">
                    <img src="/assets/theam-default/images/logo-print.png" alt="">
                </div>
                <div class="col-6 address">
                    <h6 class="text-uppercase"> WWW.MYTRADER.BIZ</h6>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="row invoice">
                <div class="col-8 details">
                    <h5 class="text-uppercase">Memorandum of Understanding</h5>
                    <p>Membership No : {{$funding_payment->getUser->membership_no}} <br>
                        Funding Id : #{{$funding_payment->id}} <br>
                        Funding Date : {{$funding_payment->created_at}} <br>
                        Approved Date : {{$funding_payment->approved_date}}</p>
                </div>
                <div class="col-4 amount">
                    <p class="text-uppercase"><b> Funding Amomunt - ${{$funding_payment->trading_amount}}</b></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 notice">
                    <p >This memorandum of understanding, dated <b>{{$funding_payment->created_at}}</b>,is entered into by and between the 
                        www.mytrader.biz platform and <b>{{$funding_payment->getUser->full_name}} </b>
                        (Id No.: <b>{{$funding_payment->getUser->nic_no}}</b> who is below mentioned as the crypto provider.
                    </p>
                    <ol>
                   <li>
                        Crypto Provider is assured that he/her is funding to www.mytrader.biz USD {{$funding_payment->trading_amount}} worth of cryptocurrencies for trade on Stock Markets, Commodities, Forex & Crypto Currencies by his/her own discretion & authority.
                    </li> 
                    <li>
                        Www.mytrader.biz will trade them on relevant platforms & will provide benefits to cryptocurrency providers through the profits that they make. 
                    </li>
                    <li>
                        Trading of International Stock Markets, Forex, Commodities & Crypto Currencies carries a high-level risk and at the same time, it is gaining high profits and may not be suitable for all kinds of entrepreneurs, investors or funders. Before deciding to fund www.mytrade.biz, the crypto provider assures that he has carefully considered his funding objectives, level of experience and risk appetite.
                    </li>
                    <li>
                        The possibility exists that the crypto provider could have a loss of some or all of his initial funds and therefore he shouldn't fund that he cannot afford to lose. The crypto provider should be aware the all risks associated with high-level risk investments or funding, and he/her assures that he/her has taken the advice of own independent financial adviser regarding the doubts before funding to www.mytrader.biz.
                    </li>
                    <li>
                        Any opinions, news, chats, research, analysis, prices or other information on this website is provided as general market information for getting a general understanding of the global market & educational purposes only. It does not constitute investment advice. Www.mytrader.biz should not be relied upon as a substitute for extensive independent market research. Before making or getting any actual investment decisions, opinions, market data, recommendations or any other content is should be researched by the crypto provider himself.
                    </li> 
                    <li>
                        According to high global market fluctuations, recessions, inflations, market manipulations, wars,  natural disasters & more incidents, gains & losses also will be changed as same. Maybe totally the crypto provider could lose his entire funds. Moreover, he/her should always understand that past performance is not necessarily indicative of future results.
                    </li>
                    <li>
                        Www.mytrader.biz assure that it will provide security for personal information that the crypto provider provides to www.mytrader.biz when funding. The personal information that www.mytrader.biz has given by the crypto provider will not be linked with any other party. Also, the crypto provider’s data will be protected if he follows the project engagement procedure accurately.
                    </li>
                    <li>
                        If there would be affected by any cyber-attacks on the platforms that www.mytrader.biz is trading, then the time period of reclaiming the funds will be much longer & sometimes it couldn’t be reclaimed. The crypto provider assures that he/her understood the effects due to such incidents before funding. In addition, www.mytrader.biz should provide the relevant reports of platforms that were affected by the attack & realized lost funds.
                    </li>
                    <li>
                        The conditions mentioned in this MOU will be automatically cancelled on the day of completing the 15 months after the funding was approved.
                    </li>
                    <li>
                        Www.mytrader.biz notify that the project hasn’t been granted any authority to take funds from the crypto provider for intraday trading or any other activities by any related authority parties. This contract is made by and between the crypto provider and www.mytrader.biz by this document. Moreover, www.mytrader.biz emphasizes that www.mytrader.biz is not a finance company or related regulated company; it is just a project that provides a trading service for the clients who request the facility. 
                    </li>
                    <li>
                        This service will be provided only by the 100% demand of the crypto provider and www.mytrader.biz has no objectives to call for investments or funds from the crypto provider for trading or any other activities.
                    </li>
                    <li>
                        Www.mytrader.biz is the service provider and the Cryptocurrency provider is the Service Recipient according to this MOU.
                    </li>
                    <li>
                        Crypto Provider assures that funding in this www.mytrader.biz service is his/her independent discretion & any of the other parties including mytrader.biz will not be responsible.
                    </li>
                    <li>
                        Moreover, the crypto provider confirms that he/her has read all the facts and understands the disclaimer here and that will abide by all those rules and regulations as stated by www.mytrader.biz.
                    </li>    
                    </ol>
                    <p>This document is automatically generated by the database and signatures aren't required.</p>
                    <p>Team WWW.MYTRADER.BIZ</p>
                    {{-- <p>S A P K Luke <br>
                        Director – Technical Developments & Operations <br>
                        WWW.MYTRADER.BIZ
                    </p> --}}
                </div>
            </div>
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>

