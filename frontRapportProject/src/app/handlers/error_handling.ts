const errors = new Array<string>();
export function handling(message): Promise<string[]> {
    return new Promise((resolve, reject) => {
        errors.push(message);
        if(errors.length>0){
            resolve(errors);
        }else reject(['No error']);
    })
}