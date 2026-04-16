import { useHead } from '@/bootstrap/Context/HeadContext'
import { useContext, useEffect } from 'react'
import { HeadContext } from '@/bootstrap/Context/HeadContext'
import React from "react"

export const NotFound = () => {
    const ctx = useContext(HeadContext)

    ctx.notFound = true

    useHead({ title: '404 — Страница не найдена' })

    return <div>404 — Страница не найдена</div>
}