import { Route, Routes } from "react-router";
import React from "react";
import { AboutController } from "@/app/Controllers/AboutController";
import { IndexController } from "@/app/Controllers/IndexController";
import { NotFound } from "@/resources/views/Pages/NotFound";

export const AppRoutes = () => {
    return (
        <Routes>
            <Route path="/" element={<IndexController />} />
            <Route path="/about" element={<AboutController />} />
            <Route path="*" element={<NotFound />} />
        </Routes>
    )
}