@inject('carbon', 'Carbon\Carbon')

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        body {
            /* font-family: 'Times New Roman', Times, serif; */
            font-family: 'dejavu sans';
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            /* background-color: #f3f3f3; */
            background: url('https://catherineasquithgallery.com/uploads/posts/2021-03/1614787841_222-p-strogii-fon-dlya-prezentatsii-230.png') center;
        }

        .certificate {
            width: 100%;
            /* background: url('path_to_your_image/удостоверение%20фис%20фрдо700.webp') no-repeat center; */
            background-size: cover;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
            box-sizing: border-box;
            margin-top: 250px
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
            margin: 0;
        }

        .header p {
            font-size: 14px;
            margin: 5px 0;
        }

        .details {
            font-size: 14px;
            margin-bottom: 20px;
            padding-left: 40px;
            line-height: 1.5;
        }

        .details p {
            margin: 10px 0;
        }

        .details p strong {
            margin-left: 10px;
        }

        .signature {
            font-size: 14px;
            margin-top: 50px;
            padding-left: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .signature .director,
        .signature .date {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .signature .director span,
        .signature .date span {
            margin-top: 10px;
        }

        .stamp {
            position: absolute;
            bottom: 50px;
            right: 50px;
            width: 100px;
            height: 100px;
            background: url('path_to_stamp_image/stamp.png') no-repeat center;
            background-size: contain;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <div class="header">
            <h1>УДОСТОВЕРЕНИЕ</h1>
            <p>о повышении квалификации</p>
            <p>{{ $group->uuID }}</p>
        </div>
        <div class="details">
            <p style="text-align: center">Негосударственное образовательное частное учреждение дополнительного профессионального образования <span>«Центр Повышения Квалификации и Охраны Труда»</span>
            </p>
            <br>
            <p>Настоящее удостоверение свидетельствует о том, что</p>
            <p><strong style="margin: 0">{{ $student->name }}</strong></p>
            <p>в период с <strong>02.02.2022 г.</strong> по <strong>02.06.2022 г.</strong></p>
            <p>прошел(а) обучение в <strong>НОЧУ ДПО «ЦПК и ОТ»</strong></p>
            <p>по программе дополнительного профессионального образования</p>
            <p><strong style="margin: 0">«{{ $course->name }}»</strong></p>
            <p>в объеме <strong>{{ $course->duration }}</strong> академических часов(часов)</p>
            <p>Решение аттестационной комиссии от <strong>{{ $carbon::now()->format('d.m.Y') }} г.</strong></p>
        </div>
        <div class="signature">
            <div class="director">
                <span>Директор</span>
                <span>Градолово А. И.</span>
            </div>
            <div class="date">
                <span>Дата выдачи</span>
                <span><strong>{{ $carbon::now()->format('d.m.Y') }} г.</strong></span>
            </div>
        </div>
        <div class="stamp"></div>
    </div>
</body>

</html>
