import {AuthRole} from "./AuthRole";

export class Role {
    role: AuthRole;

    constructor(role: AuthRole) {
        this.role = role;
    }

    isAdmin(): boolean {
        return this.role === 'admin';
    }

    isModer(): boolean {
        return this.role === 'moderator';
    }

    isUser(): boolean {
        return this.role === 'user';
    }

    isGuest(): boolean {
        return this.role === 'guest';
    }
}
