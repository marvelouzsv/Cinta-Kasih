import { Firestore } from '@google-cloud/firestore';

const storeData = async (id, data) => {
  const db = new Firestore({
    keyFilename: process.env.GOOGLE_APPLICATION_CREDENTIALS,
    projectId: 'project-id',
    databaseId: 'project-database',
  });

  const predictCollection = db.collection('project-collection');

  return predictCollection.doc(id).set(data);
};

export default storeData;
