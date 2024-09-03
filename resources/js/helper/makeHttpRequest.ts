import { APP } from "../App/APP";

type methodType = 'GET' | 'POST' | 'DELETE' | 'PUT';

export function makeHttpRequests<TInput, TResponse>
    (endpoint: string, Requestmethod: methodType, input: TInput) {
    return new Promise(async (resolve, reject) => {
        try {
            const response = await fetch(`${APP.apiBaseUrl}/${endpoint}`, {
                method: Requestmethod,
                headers: {
                    "content-type": "application/json",
                    // 'Authorization': " Bearer 1|AavWnMrvF55cYfJsQNUEPAQtOLKVVyROekLXC5wzc0df6435"
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