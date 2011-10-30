update SalesTransaction set date = NOW()
where salesTransactionId <=20;

update Item set dateAdded = NOW();
