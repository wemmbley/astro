import { renderToString } from 'react-dom/server'
import { StaticRouter } from "react-router"
import { AppRoutes } from "@/routes/routes";
import React from "react";
import { HeadContext } from "./Context/HeadContext";

export function render(url) {
    const headData = {}
    const context = {}

    const appHtml = renderToString(
        <HeadContext.Provider value={headData}>
            <StaticRouter location={url}>
                <AppRoutes />
            </StaticRouter>
        </HeadContext.Provider>
    )

    return { appHtml, headData, context }
}