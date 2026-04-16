import { $fetch } from "@/helpers/Utils/helpers";
import { aboutSchema } from "@/app/Requests/About";

export async function getAboutPage()
{
    return await $fetch(
        "https://jsonplaceholder.typicode.com/users/1",
        aboutSchema
    );
}