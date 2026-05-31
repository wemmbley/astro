import One from "@/Resources/Assets/Matrix/Tarot/1.jpg";
import Two from "@/Resources/Assets/Matrix/Tarot/2.jpg";
import Three from "@/Resources/Assets/Matrix/Tarot/3.jpg";
import Four from "@/Resources/Assets/Matrix/Tarot/4.jpg";
import Five from "@/Resources/Assets/Matrix/Tarot/5.jpg";
import Six from "@/Resources/Assets/Matrix/Tarot/6.jpg";
import Seven from "@/Resources/Assets/Matrix/Tarot/7.jpg";
import Eight from "@/Resources/Assets/Matrix/Tarot/8.jpg";
import Nine from "@/Resources/Assets/Matrix/Tarot/9.png";
import Ten from "@/Resources/Assets/Matrix/Tarot/10.png";
import Eleven from "@/Resources/Assets/Matrix/Tarot/11.jpg";
import Twelve from "@/Resources/Assets/Matrix/Tarot/12.jpg";
import Thirteen from "@/Resources/Assets/Matrix/Tarot/13.png";
import Fourteen from "@/Resources/Assets/Matrix/Tarot/14.jpg";
import Fifteen from "@/Resources/Assets/Matrix/Tarot/15.jpg";
import Sixteen from "@/Resources/Assets/Matrix/Tarot/16.jpg";
import Seventeen from "@/Resources/Assets/Matrix/Tarot/17.jpg";
import Eighteen from "@/Resources/Assets/Matrix/Tarot/18.png";
import Nineteen from "@/Resources/Assets/Matrix/Tarot/19.png";
import Twenty from "@/Resources/Assets/Matrix/Tarot/20.jpg";
import TwentyOne from "@/Resources/Assets/Matrix/Tarot/21.jpg";
import TwentyTwo from "@/Resources/Assets/Matrix/Tarot/22.jpg";

const ImageMapper: Record<number, string> = {
    1: One,
    2: Two,
    3: Three,
    4: Four,
    5: Five,
    6: Six,
    7: Seven,
    8: Eight,
    9: Nine,
    10: Ten,
    11: Eleven,
    12: Twelve,
    13: Thirteen,
    14: Fourteen,
    15: Fifteen,
    16: Sixteen,
    17: Seventeen,
    18: Eighteen,
    19: Nineteen,
    20: Twenty,
    21: TwentyOne,
    22: TwentyTwo,
};

export function getArcaneImage(arcaneNumber: number) {
    if (arcaneNumber < 1 || arcaneNumber > 22) {
        return null;
    }

    return ImageMapper[arcaneNumber];
}
