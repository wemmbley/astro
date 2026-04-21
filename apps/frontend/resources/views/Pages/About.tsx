import { Link } from 'react-router'
import React, { useState } from "react";
import { Button } from 'primereact/button';
import { Dialog } from 'primereact/dialog';
import { InputText } from 'primereact/inputtext';

export const About = () => {
    const [visible, setVisible] = useState(false);

    return (
        <div className="p-4">
            <Button label="Open" onClick={() => setVisible(true)} />

            <Dialog
                header="Header"
                dismissableMask
                visible={visible}
                onHide={() => setVisible(false)}
            >
                <p>Content</p>
            </Dialog>
        </div>
    );
}