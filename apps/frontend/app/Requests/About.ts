import { object, string, number, date, InferType } from 'yup';

export const aboutSchema = object({
    title: string().required(),
    content: string().required(),
});