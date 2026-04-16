import React from "react";
import { Link } from 'react-router'

export const Index = () => {
    return <>
        <h1>Hello, Index!</h1>
        <Link to="/about">About</Link>
    </>
}