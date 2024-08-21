import { reverse, uniq } from "lodash-es";
import { boolean } from "yup";

export const concatClasses = (classes: string[]) =>
    uniq([...classes].reverse())
        .reverse()
        .join(" ");

export const isNullOrUndefined = (v: any) => v === undefined || v === null;

export const removeValueFromObject = (
    input: Record<string, any>,
    removeIterator: (v: any, k: string) => boolean
) => {
    const output: Record<string, any> = {};

    for (const k in input) {
        if (Object.prototype.hasOwnProperty.call(input, k)) {
            const element = input[k];

            // Skip if the removeIterator function returns true
            if (removeIterator(element, k)) {
                continue;
            }

            // Handle primitives, arrays, and null
            if (
                element === null ||
                Array.isArray(element) ||
                ["string", "number", "boolean"].includes(typeof element) ||
                element instanceof Date
            ) {
                output[k] = element;
                continue;
            }

            // Handle nested objects (recursion)
            if (typeof element === "object") {
                const nestedObject = removeValueFromObject(
                    element,
                    removeIterator
                );

                // Only add the nested object if it's not empty
                if (Object.keys(nestedObject).length > 0) {
                    output[k] = nestedObject;
                }
                continue;
            }
        }
    }

    return output;
};
