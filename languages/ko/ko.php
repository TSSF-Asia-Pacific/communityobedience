<?php
namespace languages\ko;

use languages\AbstractLanguage;

class ko extends AbstractLanguage
{
    public $name = "Korean";

    public $dateLocale = 'ko';

    public $dailyPrayerOffering = "날마다 이 기도문을 읽되, 할 수 있으면 아침기도나 저녁기도를 드리는 가운데 이 기도도 바칩니다.";

    public $gloriaPatra = "
        성부와,<br/>
        성자와,<br/>
        성령의 이름으로. <strong>아멘</strong>";

    public $openingPrayer = "
        이제 여기와 세상의 모든 당신의 교회에서,<br/>
        지극히 거룩하신 주 예수 그리스도를 높이 받드나이다.<br/>
        당신의 거룩한 십자가로 세상을 구속하셨으니 우리가 당신을 찬양하나이다.<strong>아멘</strong>";

    public $principleRubricTitleDay31 = "제3회 원칙";

    public $principleRubricTitleNormal = "제3회의 원칙 중 그날의 것을 읽습니다";

    public $collectTitle = "제3회 공동체 본기도";

    /**
     * @var string[] Array of Collect days, Sunday is the first item in the array
     */
    public $collectDays = [
        "주일 본기도",
        "월요일 본기도",
        "화요일 본기도",
        "수요일 본기도",
        "목요일 본기도",
        "금요일 본기도",
        "토요일 본기도"
    ];

    public $communityPrayer = "
        하느님, 프란시스 수도회 제3회를 주심에 당신께 감사하나이다. 기도하오니, 우리가 공동체와 기도 안에서 하나 되도록 우리를 엮어 주소서. 당신의 종인 우리들이 프란시스 성인의 모범을 따라 당신의 거룩한 이름을 영광스럽게 받들게 하시며, 사람들을 당신의 사랑 안으로 이끌어오게 하소서. 우리 주 예수 그리스도를 통하여 기도하나이다. <strong>아멘</strong>";

    public $either = "다음 둘 중 하나를 바치며 마칩니다";

    public $orDot = "또는...";

    public $blessingOne = "
        복되신 성모여, 우리를 위해 기도해 주소서.<br/>
        성 프란시스여, 우리를 위해 기도해 주소서.<br/>
        성 클라라여, 우리를 위해 기도해 주소서.<br/>
        제3회의 모든 성인들이여, 우리를 위해 기도해 주소서.<br/>
        거룩한 천사들이여, 우리를 살펴보시고, 우리와 친구 되어 주소서.<br/>
        주 예수여, 우리에게 당신의 복과 당신의 평화를 주소서. <strong>아멘</strong>";

    public $blessingTwo = "
        우리 주 예수 그리스도의 은총과 
        하느님의 사랑과  
        성령께서 주시는 친교가
        항상 우리와 함께하소서. <strong>아멘</strong>";

    public $copyright = "[Scripture quotations are from] New Revised Standard Version Bible, copyright &copy; 1989 National
    Council of the Churches of Christ in the United States of America. Used by permission. All rights reserved.";
}
