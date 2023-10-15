<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>اطلاعات تجهیزات پرسنل</title>
    <style type="text/css">
        body {
            font-family: 'vazir', serif;
            direction: rtl;
        }

        .tg {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            overflow: hidden;
            padding: 10px 10px;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            font-weight: normal;
            overflow: hidden;
            padding: 10px 10px;
            word-break: normal;
        }

        .tg .tg-0lax {
            text-align: center;
            vertical-align: top;
            font-weight: bold
        }
    </style>
</head>
<body>
<div>
    <h2 style="text-align: center">
        تجهیزات پرسنل
        {{ $personInfo->name . ' ' . $personInfo->family  . ' با کد ' . $personInfo->personnel_code . ' و کد ملی: ' . $personInfo->national_code}}
    </h2>

    {{--    cases--}}
    <div style="text-align: center;margin: 0 auto;">
        <table class="tg">
            <thead>
            <tr>
                <th class="tg-0lax" colspan="3">کیس های ثبت شده</th>
            </tr>
            <tr>
                <td class="tg-0lax">ردیف</td>
                <td class="tg-0lax">مشخصات</td>
                <td class="tg-0lax">تاریخ تحویل</td>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
