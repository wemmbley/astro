import { hydrateRoot } from 'react-dom/client'
import { BrowserRouter, Route, Routes } from "react-router";
import { AppRoutes } from "@/routes/routes";
import React from "react";
import 'primereact/resources/themes/lara-light-blue/theme.css';
import 'primereact/resources/primereact.min.css';
import '@/resources/css/main.css'

hydrateRoot(
    document.getElementById('app'),
    <BrowserRouter>
        <AppRoutes />
    </BrowserRouter>
)