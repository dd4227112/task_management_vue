import { APP } from "../App/APP";

type methodType = 'GET' | 'POST' | 'DELETE' | 'PUT';

export function makeAuthorizedHttpRequest<TInput, TResponse>
    (endpoint: string, Requestmethod: methodType, input?: TInput) { // add ? on input to make it optional
    return new Promise(async (resolve, reject) => {
        try {
            const response = await fetch(`${APP.apiBaseUrl}/${endpoint}`, {
                method: Requestmethod,
                headers: {
                    "content-type": "application/json",
                    'Authorization': " Bearer 20|LLFunnkALxi1I5AC0sV1gMP2j6mZzgZffDCDCLFo8ec8b43a"
                },
                body: JSON.stringify(input)
            });
            const data:TResponse = await response.json();
            if (!response.ok) {
                reject(data)
            }
            resolve(data)
        } catch (error) {
            reject(error)
        }

    })
}