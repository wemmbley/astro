import {
    Anahata, Ajna, Manipura, Muladhara, Sahasrara, Svadhistana, Vishudha,
    AnahataArchetype, AjnaArchetype, ManipuraArchetype, MuladharaArchetype,
    SahasraraArchetype, SvadhistanaArchetype, VishudhaArchetype,
} from "@/Modules/Matrix/Domain/ChakraImages"

type ChakraName =
    | "Muladhara"
    | "Svadhistana"
    | "Manipura"
    | "Anahata"
    | "Vishudha"
    | "Ajna"
    | "Sahasrara";

type Chakra = {
    color: string;
    imageChakra: string;
    imageArchetype: string;
};

type ChakraBag = Record<ChakraName, Chakra>;

const ChakraMap: ChakraBag = {
    Muladhara: {
        color: "#E53935",
        imageChakra: Muladhara,
        imageArchetype: MuladharaArchetype,
    },
    Svadhistana: {
        color: "#FB8C00",
        imageChakra: Svadhistana,
        imageArchetype: SvadhistanaArchetype,
    },
    Manipura: {
        color: "#FDD835",
        imageChakra: Manipura,
        imageArchetype: ManipuraArchetype,
    },
    Anahata: {
        color: "#43A047",
        imageChakra: Anahata,
        imageArchetype: AnahataArchetype,
    },
    Vishudha: {
        color: "#29B6F6",
        imageChakra: Vishudha,
        imageArchetype: VishudhaArchetype,
    },
    Ajna: {
        color: "#8000FF",
        imageChakra: Ajna,
        imageArchetype: AjnaArchetype,
    },
    Sahasrara: {
        color: "#C827F5",
        imageChakra: Sahasrara,
        imageArchetype: SahasraraArchetype,
    },
};

const ChakraOrder: ChakraName[] = [
    "Muladhara",
    "Svadhistana",
    "Manipura",
    "Anahata",
    "Vishudha",
    "Ajna",
    "Sahasrara",
];

export {ChakraMap, ChakraOrder};
export type { ChakraName };
