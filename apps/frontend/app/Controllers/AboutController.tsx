import { About } from "@/resources/views/Pages/About";
import React, {useEffect} from "react";
import { getAboutPage } from "@/app/Models/About";
import { useHead } from "@/bootstrap/Context/HeadContext";

export const AboutController = () => {
    useHead({ title: 'About — My Blog' })

    // Throwing validation error because schema invalid.
    // This needed for testing, to show how it's work.
    // After you understand it works, you can remove it.
    useEffect(() => {
        getAboutPage().then(res => {
            console.log(res)
        });
    }, []);

    return (<About />);
}