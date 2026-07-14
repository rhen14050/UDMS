<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    
    <p>Hello Sir/Mam,</p>

    <p>You have a UD request that requires your attention and update.</p>

    <h3>{{ $emailHeader }}</h3>    

    @foreach($inChargeList as $role)
    <p><strong>In-Charge:</strong> {{ $role }}</p>
    @endforeach

    <ul>
        <li><strong>UD Control No.:</strong> {{ $ppcEmailData['ud_ctrlno'] }}</li>
        <li><strong>PO Number:</strong> {{ $ppcEmailData['po_num'] }}</li>
        <li><strong>Product Name:</strong> {{ $ppcEmailData['p_name'] }}</li>
        <li><strong>PPC Remarks: </strong> {{ $ppcEmailData['ppc_remarks'] }}</li>
        {{-- <li><strong>Attention To:</strong> {{ $attentionNamesString }}</li> --}}
    </ul>

    <p>Please log in to the UD Monitoring System to review the details of the request and provide any necessary updates.</p>

    <p><a href="http://rapidx/">Access the UD Monitoring System here</a></p>

    <p>Thank you for your prompt attention.</p>

    <div class="footer">
        <p style="text-align:center;">
            <strong><em>For any concerns, please contact the ISS team.</em></strong>
        </p>

        <p style="text-align:justify;">
            <strong>Notice of Disclaimer:</strong><br>
            This message contains confidential information intended for the designated recipient(s) only and is protected by law. 
            If you are not the intended recipient, please delete this message immediately. Any disclosure, copying, distribution, 
            or use of this information, or any action taken based on its contents, is strictly prohibited.
        </p>
    </div>
</body>
</html>