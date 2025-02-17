'use server'

import {userService} from "@/services/userService";

export async function createUser(data) {
    return await userService.createUser(data);
}

export async function getNotifications() {
    return await userService.getNotifications();
}