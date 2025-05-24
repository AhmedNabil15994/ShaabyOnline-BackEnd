@component('mail::message')

    <div dir="rtl" style="text-align:right;">
        <div class="" style="justify-content: center; margin-bottom: 20px; text-align: center;">
            <img style="height: 150px;"
                 src="{{ config('setting.images.logo') ? url(config('setting.images.logo')) : url('frontend/images/header-logo.png') }}"
                 alt="{{ config('app.name') }}" style="">
        </div>
        <h2>
            <center>Low Quantity Products In Stocks</center>
        </h2>

        <table
            style="font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%; direction: ltr;">
            <tr>
                <th style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #4CAF50;color: white; padding-left: 10px; width: 50px;">
                    #
                </th>
                <th style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #4CAF50;color: white; padding-left: 10px; width: 200px;">
                    Product Title
                </th>
                <th style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #4CAF50;color: white; padding-left: 10px; width: 100px;">
                    Qty In Stock
                </th>
            </tr>

            @foreach($products as $k => $product)
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ ++$k }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $product->title }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $product->qty }}</td>
                </tr>
            @endforeach

        </table>

        <br>
        <center>
            Thanks,
            <br>
            {{ config('app.name') }}
        </center>
    </div>


@endcomponent
