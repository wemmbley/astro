import { hydrateRoot } from 'react-dom/client'
import { BrowserRouter, Route, Routes } from "react-router";
import { AppRoutes } from "@/routes/routes";
import React from "react";

hydrateRoot(
    document.getElementById('app'),
    <BrowserRouter>
        <AppRoutes />
    </BrowserRouter>
)