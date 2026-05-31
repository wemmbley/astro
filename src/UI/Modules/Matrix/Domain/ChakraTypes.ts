import {
    Anahata, Ajna, Manipura, Muladhara, Sahasrara, Svadhistana, Vishudha,
    AnahataArchetype, AjnaArchetype, ManipuraArchetype, MuladharaArchetype,
    SahasraraArchetype, SvadhistanaArchetype, VishudhaArchetype,
} from "@/Modules/Matrix/Domain/ChakraImages"

type ChakraName =
    | "muladhara"
    | "svadhisthana"
    | "manipura"
    | "anahata"
    | "vishuddha"
    | "ajna"
    | "sahasrara";

type Chakra = {
    name: string,
    color: string;
    imageChakra: string;
    imageArchetype: string;
};

type ChakraBag = Record<ChakraName, Chakra>;

const ChakraMap: ChakraBag = {
    muladhara: {
        name: 'Муладхара',
        color: "#E53935",
        imageChakra: Muladhara,
        imageArchetype: MuladharaArchetype,
    },
    svadhisthana: {
        name: 'Свадхистана',
        color: "#FB8C00",
        imageChakra: Svadhistana,
        imageArchetype: SvadhistanaArchetype,
    },
    manipura: {
        name: 'Манипура',
        color: "#FDD835",
        imageChakra: Manipura,
        imageArchetype: ManipuraArchetype,
    },
    anahata: {
        name: 'Анахата',
        color: "#43A047",
        imageChakra: Anahata,
        imageArchetype: AnahataArchetype,
    },
    vishuddha: {
        name: 'Вишудха',
        color: "#29B6F6",
        imageChakra: Vishudha,
        imageArchetype: VishudhaArchetype,
    },
    ajna: {
        name: 'Аджна',
        color: "#8000FF",
        imageChakra: Ajna,
        imageArchetype: AjnaArchetype,
    },
    sahasrara: {
        name: 'Сахасрара',
        color: "#C827F5",
        imageChakra: Sahasrara,
        imageArchetype: SahasraraArchetype,
    },
};

const ChakraOrder: ChakraName[] = [
    "muladhara",
    "svadhisthana",
    "manipura",
    "anahata",
    "vishuddha",
    "ajna",
    "sahasrara",
];

export {ChakraMap, ChakraOrder};
export type { ChakraName };
