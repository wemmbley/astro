import React from "react"
import { Link } from 'react-router'

export const About = () => {
    return <>
        <h1>About page</h1>
        <p>My about page here</p>
        <Link to="/">Index</Link>
    </>
}