import React from "react";
import { Index } from "@/resources/views/Pages/Index";
import {useHead} from "@/bootstrap/Context/HeadContext";

export const IndexController = () => {
    useHead({ title: 'Main page' })

    return (<Index />);
}