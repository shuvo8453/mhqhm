<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <style>
        .student_section{
            height: 500px;
            margin-bottom: 10px;
        }
        .header_container{
            width: 100%;
            text-align: center;
        }
        .logo{
            margin: 0;
        }
        .InstituteName{
            margin: 0;
            line-height: 1.0;
            font-size: 24px;
            font-weight: bold;
        }
        .info{
            margin-top: 15px;
            height: 60px;
            width: 100%;
        }
        .basic_info{
            width: 100%;
            font-size: 15px;
            font-weight: bold;
        }
        .basic_info_text {
            width: 50%;
        }
        .date{
            text-align: right;
        }
        .admission{
            text-align: center;
            font-size: 18px;
        }
        .signature{
            float: right;
            margin-top: 30px;
        }
        .guardian{
            border-top: 1px solid #000;
            float: left;
        }
        .pi{
            border-collapse: collapse;
            background: red;
        }
        .pi td, th {
            border: 1px solid #000;
            padding: 10px 2px;
            min-width: 165px;

            background: white;
            box-sizing: border-box;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="student_section">
    <div class="header_container ">
        <div class="logo">
            <img src="{{ url($systemSetting['logo']) }}" class="logo" alt="logo" style="width:70px;height:70px;">
        </div>
        <p class="InstituteName">{{$systemSetting['siteName']}}</p>
        <small>{{ $systemSetting['address'] }}</small>
    </div>

    <div>
        <h4 class="admission">Money Receipt</h4>
    </div>

    <table class="basic_info">
        <tr>
            <td class="basic_info_text">
                <span >Sl No: #{{ str_pad( $payment->id, 5, '0', STR_PAD_LEFT) }}</span>
            </td>
            <td class="basic_info_text date">
                <span>Date: {{$payment->date}}</span>
            </td>
        </tr>
    </table>

    <div class="info">
        <table class="basic_info">
            <tr>
                <td class="basic_info_text">
                    <span>ID: {{$payment->user->username}}</span>
                </td>
                <td class="basic_info_text">
                    <span>Name: {{$payment->user->details->first_name . ' ' . $payment->user->details->last_name}}</span>
                </td>
                <td class="basic_info_text">
                    <span>Class: {{$payment->user->group->name}}</span>
                </td>
            </tr>
        </table>
    </div>

    <table class="pi">
        <tr >
            <th >
                <span class="text-center">Name</span>
            </th>
            <th >
                <span class="text-center">Actual amount</span>
            </th>
            <th >
                <span class="text-center">Due amount</span>
            </th>
            <th >
                <span class="text-center">Paid amount</span>
            </th>

        </tr>
        @foreach($payment->details as $invoice)
        <tr>
            <td class="text-center">
                <span >{{$invoice->feeType->name}} </span>
            </td>
            <td><span >{{$invoice->actual_amount}} </span></td>
            <td><span >{{$invoice->due_amount}} </span></td>
            <td><span >{{$invoice->paid_amount}} </span></td>
        </tr>
        @endforeach

        <tr>
            <td colspan="3"></td>
            <td>
                <div>
                    <p> <span style="font-weight: bold"> Total actual amount: {{$payment->total_actual_amount}} </span></p>
                    <p> <span style="font-weight: bold"> Total Due amount: {{$payment->total_due_amount}} </span></p>
                    <p> <span style="font-weight: bold"> Total Paid amount: {{$payment->total_paid_amount}} </span></p>
                </div>
            </td>
        </tr>
    </table>

    <div class="signature">
        <p class="guardian basic_info">
            Author's signature
        </p>
        <p class="author"></p>
    </div>
</div>

</body>
</html>
