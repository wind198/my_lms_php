import type { IEntity } from "./entity.type";

export type IUserType = "student" | "teacher" | "staff";

export type IUser = IEntity & {
    first_name: string;
    last_name: string;
    email: string;
    password?: string; // Optional because password may not be needed on the frontend
    userType: IUserType;
    created_at: string; // Assuming dates are in ISO string format
    updatedAt: string; // Assuming dates are in ISO string format
};
