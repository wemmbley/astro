import React from "react";
import { Link } from 'react-router'

export const Index = () => {
    return <>
        <h1 className="text-red-500 text-3xl font-bold">Hello, Index!</h1>
        <Link to="/about">About</Link>
    </>
}